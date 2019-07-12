/**
 *  @file     scaleCGI.cpp
 *  @author   Philippe SIMIER (Touchard Wahington le Mans)
 *  @license  BSD (see license.txt)
 *  @date     02 juillet 2018
 *  @brief    programme pour déterminer l'échelle via API HTTP
 *            ce programme détermine la constante scale et
 *            l'enregistre dans le fichier configuration.ini
 *            compilation: g++ scaleCGI.cpp hx711.cpp SimpleIni.cpp  spi.c -o scaleCGI
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
    int gain, offset;
    string key;
    float poids = 0.0;
    float scale = 1.0;


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
    offset = ini.GetValue<int>("balance", "offset", 0);
    balance.fixerOffset(offset);

    // lecture de la masse connue (methode POST)

    getline(cin, key, '=');
    cin >> poids;
    cout << "\"poids\":" << poids << "," << endl;
    if (poids <= 0.0){
        cout << "\"success\": false, " << endl;
        cout << "\"error\":\"Le poids doit être supérieur à zéro\"" << endl;
        cout << "}" << endl;
        return -1;
    }

    int x;
    int nb = 21;
    vector<int> valeur;

    // Lecture de nb valeurs
    for (int i=0; i < nb; i++)
    {
        valeur.push_back( balance.obtenirValeur());
    }

    // Tri des valeurs grâce à la fonction std::sort
    sort (valeur.begin(), valeur.end());

    // valeurBrute prend la mediane de la série
    x = valeur.at(nb/2);

    scale = (float)(x - offset)/poids;

    ini.SetValue<float>("balance", "scale", scale);

    // Ecriture du fichier de configuration
    if(!ini.SaveAs(CONFIGURATION))
    {
        cout << "\"success\": false, " << endl;
        cout << "\"error\":\"Erreur d'écriture du fichier de configuration\"" << endl;
        cout << "}" << endl;
        return -1;
    }
    else
    {
        cout << "\"scale\":" << scale << "," << endl;
        cout << "\"success\": true " << endl;
        cout << "}" << endl;
        return 0;

    }
}

