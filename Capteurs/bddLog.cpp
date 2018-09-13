/*!
    @file     bddLog.cpp
    @author   Philippe SIMIER (Touchard Wahington le Mans)
    @license  BSD (see license.txt)
    @brief    Programme pour loger les valeurs de poids dans la base de données
    @date     Juillet 2018
    @version  v1.0 - First release
    @detail    Prérequis    : sudo apt-get install libmysqlcppconn-dev
    Compilation  : g++  bddLog.cpp -lmysqlcppconn SimpleIni.cpp hx711.cpp spi.c bme280.cpp bh1750.cpp i2c.cpp -o bddLog
    Execution    : ./bddLog
*/


#include <iostream>
#include <fstream>
#include <iomanip>

#include <cppconn/driver.h>
#include <cppconn/statement.h>
#include <cppconn/exception.h>
#include <cppconn/prepared_statement.h>

#include "hx711.h"
#include "bme280.h"
#include "bh1750.h"
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
    time_t  t = time(nullptr);
    stringstream ss;
    ss  <<  put_time( localtime(&t), "%F %T" );
    return ss.str();
}


int main() {

    SimpleIni ini;
    sql::ConnectOptionsMap connexion_locale, connexion_distante;
    sql::Driver     *driver;
    sql::Connection *con;
    sql::PreparedStatement *pstmt;
    hx711 balance;
    bme280 capteur1(0x77);
    bh1750 capteur2(0x23);
    int nbLigne;

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

    // Configuration de la balance
    balance.fixerEchelle( ini.GetValue<float>("balance", "scale", 1.0 ));
    balance.fixerOffset( ini.GetValue<int>("balance", "offset", 0));
    balance.configurerGain(  ini.GetValue<int>("balance", "gain", 128));

    // Configuration du capteur de pression
    capteur1.donnerAltitude( ini.GetValue<float>("ruche", "altitude", 0.0 ));

    // Configuration du capteur d'éclairement
    capteur2.configurer(BH1750_ONE_TIME_HIGH_RES_MODE_2);


    // Connexion à une base de données
    try {
	driver = get_driver_instance();
        con = driver->connect(connexion_distante);
        // Check de la connexion
        if(con->isValid()){
            cout  << ObtenirDateHeure() << " BDD distante : ";
	}
    }
    catch (sql::SQLException &e)
    {
        try {
            driver = get_driver_instance();
            con = driver->connect(connexion_locale);
            // Check de la connexion
            if(con->isValid()){
               cout << ObtenirDateHeure() << " BDD locale : ";
            }

        }
        catch (sql::SQLException &e)
        {
            // Gestion des exceptions pour afficher les erreurs

            cout << ObtenirDateHeure() << " # ERR: SQLException in " << __FILE__;
            cout << "(" << __FUNCTION__ << ") on line " << __LINE__ ;
            cout << " # ERR: " << e.what();
            cout << " (code erreur MySQL: " << e.getErrorCode();
            cout << ", EtatSQL: " << e.getSQLState() << " )" << endl;
            return 1;
        }
    }


        // préparation de la requête
        string sql("INSERT INTO feeds(field1,field2,field3,field4,field5,field6,id_channel) VALUES(?,?,?,?,?,?,?)");
        pstmt = con->prepareStatement(sql);
        pstmt->setDouble( 1, balance.obtenirPoids() );
        pstmt->setDouble( 2, capteur1.obtenirTemperatureEnC() );
        pstmt->setDouble( 3, capteur1.obtenirPression0() );
        pstmt->setDouble( 4, capteur1.obtenirHumidite() );
        pstmt->setDouble( 5, capteur2.obtenirLuminosite_Lux() );
        pstmt->setDouble( 6, capteur1.obtenirPointDeRosee() );
        pstmt->setInt( 7, ini.GetValue<int>("ruche", "id", 0));
        // Exécution de la requête
        nbLigne = pstmt->executeUpdate();

        delete pstmt;
        delete con;


    cout << nbLigne << endl;
    return EXIT_SUCCESS;
}

