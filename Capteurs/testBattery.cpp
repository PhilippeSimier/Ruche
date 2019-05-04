// Compilation  : g++ testBattery.cpp i2c.cpp  ina219.cpp -o testBattery 

#include <iostream>
#include <unistd.h>
#include "ina219.h"

using namespace std;

int main(){

    system("clear");
    char adresse = 0x40;
    ina219 capteur(adresse);
    float courant = 0;
    float tension = 0;


    if (!capteur.obtenirErreur()){
    	capteur.fixerCalibration_16V();
    	while(1){
	    usleep(10*1000); // Tempo 10 ms
            tension = capteur.obtenirTension_V();
            courant = capteur.obtenirCourantMoyen_A(10);
	    system("clear");
	    cout << " Tension bus   : " << fixed << setprecision (3) << tension << " V" << endl;
	    cout << " Courant bus   : " << fixed << setprecision (3) << courant << " A" << endl;
        }
    }
}
