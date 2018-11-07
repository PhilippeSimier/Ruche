/*!
    @file     weather.cpp
    @author   Philippe SIMIER (Touchard Wahington le Mans)
    @license  BSD (see license.txt)
    @brief    Programme pour obtenir la météo sur openWeather
    @date     7 Novembre 2018
    @version  v1.0 - First release
    @detail   compilation g++ weather.cpp rest.cpp -lcurl -o weather

*/

#include <iostream>
#include "rest.h"
#include <string.h>
#include <fstream>
#include <sstream>
#include <iomanip>
#include <ctime>
#include <unistd.h>

using namespace std;

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

int main(){

    rest requete;
    string req;
    string json;
    int pos = 0;

    req = "http://api.openweathermap.org/data/2.5/weather?id=3003603&appid=328242030385ad104d734bbe61bf3c25&units=metric&lang=fr";

    long code = requete.get(req);
    json = requete.getResponse();

    pos = json.find("\"temp\"");
    cout << json.substr (pos) << endl;
    cout << ObtenirDateHeure() << " Weather : " << requete.getErreurServeur(code) << endl;

    return 0;

}
