/**
 *  @file     tarageCGI.cpp
 *  @author   Philippe SIMIER (Touchard Wahington le Mans)
 *  @license  BSD (see license.txt)
 *  @date     29 juin 2018
 *  @brief    programme pour effectuer le tarage de la balance via HTTP API
 *            ce programme détermine la constante offset et
 *            l'enregistre dans le fichier configuration.ini
 *            compilation: g++ tarageCGI.cpp hx711.cpp SimpleIni.cpp  spi.c -o tarageCGI
*/
#include <iostream>
#include <fstream>
#include <iomanip>
#include "hx711.h"
#include "SimpleIni.h"

#define CONFIGURATION "/opt/Ruche/etc/configuration.ini"

using namespace std;

int main()
{

    hx711 balance;
    SimpleIni ini;
    int gain;

    cout << "Content-type: application/json" << endl << endl;
    cout << "{" << endl;

    if(!ini.Load(CONFIGURATION))
    {
        cout << "\"success\": false, " << endl;
        cout << "\"error\":\"Impossible d'ouvrir le fichier configuration.ini\"" << endl;
	cout << "}" << endl;
        return -1;
    }

    gain   = ini.GetValue<int>("balance", "gain", 128);
    balance.configurerGain(gain);

    /** début de la procédure de tarage
	21 mesures du poids sont effectuées
        seul la médiane de la série est conservée comme offset
    */
    int x,offset;
    int nb = 21;
    vector<int> valeur;

    // Lecture de nb valeurs
    for (int i=0; i < nb; i++)
    {
        valeur.push_back( balance.obtenirValeur());
    }

    // Tri des valeurs grâce à la fonction std::sort
    sort (valeur.begin(), valeur.end());

    // offset prend la mediane de la série
    offset = valeur.at(nb/2);

    cout << "\"offset\":" << offset << "," << endl;
    ini.SetValue<int>("balance", "offset", offset);

    if(!ini.Save())
    {
        cout << "\"success\": false," << endl;
        cout << "\"error\":\"Impossible d'écrire le fichier configuration.ini\"" << endl;
        cout << "}" << endl;
        return -1;
    }

    cout << "\"success\": true " << endl;
    cout << "}" << endl;
    return 0;
}
