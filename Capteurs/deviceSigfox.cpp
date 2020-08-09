/*!
    @file     deviceSigfox.cpp
    @author   Philippe SIMIER (Touchard Wahington le Mans)
    @license  BSD (see license.txt)
    @date   : 04 Aout 2020
    @brief   Programme pour l'envoi des infos du device au format JSON
    @details Renvoie le sigfox id et le PAC du device
    Compilation : g++ deviceSigfox.cpp sigfox.cpp serie.c -o deviceSigfox
    Installation: sudo chown root deviceSigfox
                  sudo chmod +s deviceSigfox
                  sudo cp deviceSigfox /usr/lib/cgi-bin/deviceSigfox
    @version	v1.0 - First release
*/

#include <iostream>
#include <string>
#include "sigfox.h"

using namespace std;

int main()
{
    Sigfox device("/dev/ttyS0", true);
    float tension0,tension1;


    // Création de l'entête
    cout << "Content-type: application/json" << endl << endl;

    cout << "{" << endl;
    // test du fct composant
    cout << "\"test\" : \"" << device.tester()  << "\"," << endl;

    // Affichage de l'identifiant
    cout << "\"Sigfox_ID\" : \"" << device.obtenirID() << "\"," << endl;

    // Affichage du PAC number
    cout << "\"PAC\" : \"" << device.obtenirPAC()  << "\"," << endl;

    // Affichage frequence émission
    cout << "\"Freq_emi\" : \"" << device.obtenirFreqEmi() << "\"," << endl;

    // Fréquence de réception
    cout << "\"Freq_rec\" : \"" << device.obtenirFreqRec() << "\"," << endl;

    // Tension d'alimentation
    device.obtenirTension(tension0,tension1);
    cout << "\"Tension0\" : \"" << tension0 << "\"," << endl;
    cout << "\"Tension1\" : \"" << tension1 << "\"," << endl;

    // Temperature
    cout << "\"Temp\" : \"" << device.obtenirTemp() << "\"" << endl;

    cout << "}" << endl;

    return 0;
}
