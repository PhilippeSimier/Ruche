/*!
    @file     weather.cpp
    @author   Philippe SIMIER (Touchard Wahington le Mans)
    @license  BSD (see license.txt)
    @brief    Programme pour obtenir la météo sur openWeather et forger
		une requète pour thingSpeak
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

string ObtenirDateHeure()
{
    locale::global(locale("fr_FR.utf8"));
    time_t t = time(0);
    char Fchar[100];
    char Tchar[100];
    string retour;
    if (strftime(Fchar, sizeof(Fchar), "%F", gmtime(&t))) {
        if (strftime(Tchar, sizeof(Tchar), "%T", gmtime(&t))) {
            string F(Fchar);
            string T(Tchar);
            retour = F + "%20" + T;
        }
    }
    return retour;
}


string ObtenirValeur(string response, string key)
{
    key = "\"" + key + "\"";
    response = response.substr (response.find(key) + key.length() + 1);
    response = response.substr (0, response.find_first_of(",}"));
    return response;
}

int main(int argc, char *argv[]){

    rest requete;
    string req;
    string json;

    ostringstream trame;

    if (argc != 2){
        return 1;
    }

    req = "http://api.openweathermap.org/data/2.5/weather?id=3003603&appid=328242030385ad104d734bbe61bf3c25&units=metric&lang=fr";

    int count = 0;
    long code = requete.get(req);
    while (code != 200 && count < 2){
        sleep(30);   // attente de 30s avant nouvel essai
        code = requete.get(req);
	count++;
    }

    if (code == 200){
        json = requete.getResponse();

        string key(argv[1]);
        trame << "https://api.thingspeak.com/update?";
        trame << "api_key=" << key;
        trame << "&field1=" <<  ObtenirValeur(json, "temp");
        trame << "&field2=" <<  ObtenirValeur(json, "pressure");
        trame << "&field3=" <<  ObtenirValeur(json, "humidity");
        trame << "&field4=" <<  ObtenirValeur(json, "speed");
        trame << "&field5=" <<  ObtenirValeur(json, "deg");
        trame << "&created_at=" << ObtenirDateHeure();

        cout << trame.str() << endl;
    }
    return 0;
}
