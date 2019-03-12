/*!
    @file     synchronisation.cpp
    @author   Philippe SIMIER (Touchard Wahington le Mans)
    @license  BSD (see license.txt)
    @brief    Programme pour transférer le contenu de la base locale vers la distante
    @date     Juillet 2018
    @version  v1.0 - First release
    @detail    Prérequis    : sudo apt-get install libmysqlcppconn-dev
    Compilation  : g++  synchronisation.cpp -lmysqlcppconn SimpleIni.cpp -o synchronisation
    Execution    : ./synchronisation
*/


#include <iostream>
#include <fstream>
#include <iomanip>

#include <cppconn/driver.h>
#include <cppconn/statement.h>
#include <cppconn/exception.h>
#include <cppconn/prepared_statement.h>


#include "SimpleIni.h"

#define CONFIGURATION "/home/pi/Ruche/configuration.ini"

using namespace std;
using namespace sql;

/**
 * @brief ObtenirDateHeure
 * @return std::string
 * @details retourne une chaine de caratères représentant la date courante
 *          au format Année-mois-jour heure:minute:seconde
 */

string ObtenirDateHeure()
{
    locale::global(locale("fr_FR.utf8"));
    time_t t = time(0);
    char mbstr[100];
    if (strftime(mbstr, sizeof(mbstr), "%F %T", localtime(&t))) {
        string ss(mbstr);
        return ss;
    }
}


int main() {

    SimpleIni ini;
    sql::ConnectOptionsMap connexion_locale, connexion_distante;
    sql::Driver            *driver;
    sql::Connection        *conDistante, *conLocale;
    sql::Statement         *stmtLocale;
    sql::PreparedStatement *pstmt;
    sql::ResultSet         *resLocale;



// Lecture du fichier de configuration

    ini.Load(CONFIGURATION);

    connexion_locale["hostName"] = (sql::SQLString)ini.GetValue<string>("BDlocale", "host", "127.0.0.1");
    connexion_locale["userName"] = (sql::SQLString)ini.GetValue<string>("BDlocale", "user", "ruche");
    connexion_locale["password"] = (sql::SQLString)ini.GetValue<string>("BDlocale", "passwd", "toto");
    connexion_locale["schema"]   = (sql::SQLString)ini.GetValue<string>("BDlocale", "bdd", "ruche");
    connexion_locale["port"] = 3306;
    connexion_locale["OPT_RECONNECT"] = false;

    connexion_distante["hostName"] = (sql::SQLString)ini.GetValue<string>("BDdistante", "host", "127.0.0.1");
    connexion_distante["userName"] = (sql::SQLString)ini.GetValue<string>("BDdistante", "user", "ruche");
    connexion_distante["password"] = (sql::SQLString)ini.GetValue<string>("BDdistante", "passwd", "toto");
    connexion_distante["schema"]   = (sql::SQLString)ini.GetValue<string>("BDdistante", "bdd", "ruche");
    connexion_distante["port"] = 3306;
    connexion_distante["OPT_RECONNECT"] = false;

    double field[8];
    string date;
    int id_channel;

    try
    {
        // Création d'une connexion aux bases de données distante et locale
        driver = get_driver_instance();
        conDistante = driver->connect(connexion_distante);
        conLocale = driver->connect(connexion_locale);

    }
    catch (sql::SQLException e)
    {
       // Si erreur on l'affiche puis on quite
       cout << ObtenirDateHeure() << " Synchronisation : " << e.what() << endl;
       return 1;
    }

    stmtLocale = conLocale->createStatement();
    resLocale = stmtLocale->executeQuery("SELECT `field1`, `field2`, `field3`, `field4`, `field5`, `field6`, `field7`, `field8`, `date`, `id_channel` FROM `feeds`");

    string sql("INSERT INTO feeds(field1, field2, field3, field4, field5, field6, field7, field8, date, id_channel) VALUES (?,?,?,?,?,?,?,?,?,?)");
    pstmt = conDistante->prepareStatement(sql);

    int nb(0);

    while(resLocale->next()) {

       pstmt->clearParameters();

       for (int i=1; i<9; i++){
           field[i]= resLocale->getDouble(i);
           pstmt->setDouble(i,field[i]);
       }

       date = resLocale->getString(9);
       pstmt->setString(9,date);

       id_channel = resLocale->getInt(10);
       pstmt->setInt(10,id_channel);
       pstmt->executeUpdate();

       nb++;
    }

    stmtLocale->execute("DELETE FROM `feeds`");

    cout << ObtenirDateHeure() << " Synchronisation : " << nb << " insertion(s)" << endl;

    // Libération de la mémoire avant de quitter
    delete pstmt;
    delete stmtLocale;
    delete conLocale;
    delete conDistante;
    delete resLocale;

    return 0;
}

