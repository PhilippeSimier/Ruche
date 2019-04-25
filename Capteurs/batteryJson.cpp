 /*!
    \file     batteryJson.cpp
    \author   Philippe SIMIER (Touchard Wahington le Mans)
    \license  BSD (see license.txt)
    \date   : 19 Avril 2019
    \brief    Programme suivi des grandeurs batterie
    \details  Renvoie les valeurs mesurées par le capteur ina219 au format JSON
              Les différentes valeures sont envoyées sur la sortie standard
	      avec une précison de deux chiffres après la virgule.
    Compilation  : g++ batteryJson.cpp ina219.cpp i2c.cpp -o batteryJson
    Installation : sudo chown root batteryJson
                   sudo chmod +s batteryJson
                   sudo mv batteryJson /usr/lib/cgi-bin/batteryJson
    \version  v1.0 - First release
*/

#include <iostream>
#include "ina219.h"

using namespace std;

int main()
{
    ina219 *capteur;

    capteur = new ina219(0x40);   // déclaration d'un capteur de type ina219 à l'adresse par défaut 0x40

    if (!capteur->obtenirErreur()){
    	float u = capteur->obtenirTension_V();
    	float i = capteur->obtenirCourantMoyen_A(500);
    	float p = u*i;
    	float soc = capteur->obtenirSOC();

    	cout << "Content-type: application/json" << endl << endl;

    	cout << "{" << endl;
	cout << "\"OK\" : true," << endl;
    	cout << "\"u\": " << fixed << setprecision (2) << u << "," << endl;
    	cout << "\"uniteU\" : \"V\"," << endl;

    	if (i < -1 || i > 1){

            cout << "\"i\":" << fixed << setprecision (2) << i << "," << endl;
            cout << "\"uniteI\" : \"A\"," << endl;
     	}
    	else{
	    cout << "\"i\":" << fixed << setprecision (2) << i * 1000 << "," << endl;
            cout << "\"uniteI\" : \"mA\"," << endl;
    	}

    	if (p < -1 || p > 1){
    	    cout << "\"p\":" << fixed << setprecision (2) << p << "," << endl;
    	    cout << "\"uniteP\" : \"W\"," << endl;
    	}
    	else{
            cout << "\"p\":" << fixed << setprecision (2) << p * 1000 << "," << endl;
            cout << "\"uniteP\" : \"mW\"," << endl;

    	}
    	cout << "\"soc\": " << fixed << setprecision (0) << soc << "," << endl;
    	cout << "\"uniteSOC\" : \"%\"" << endl;

    	cout << "}" << endl;
    } else {
        cout << "Content-type: application/json" << endl << endl;
        cout << "{" << endl;
        cout << "\"OK\" : false" << endl;
        cout << "}" << endl;


    }
    delete capteur;
    return 0;
}
