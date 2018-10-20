/*!
    @file     envoyerURL.cpp
    @author   Philippe SIMIER (Touchard Wahington le Mans)
    @license  BSD (see license.txt)
    @brief    Programme pour envoyer une requête en http -> thingSpeak
    @date     Octobre 2018
    @version  v1.0 - First release
    @detail   compilation g++ envoyerURL.cpp rest.cpp -lcurl -o envoyerURL

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
    int count = 0;

    cin >> req;

    long code = requete.get(req);

    while (code != 200 && count < 2){
	cout << ObtenirDateHeure() << " envoyerURL : " << requete.getErreurServeur(code) << endl;
        sleep(30);   // attente de 30s avant nouvel essai
        code = requete.get(req);
	count++;
    }
    cout << ObtenirDateHeure() << " envoyerURL : " << requete.getErreurServeur(code) << endl;
    return 0;

}
