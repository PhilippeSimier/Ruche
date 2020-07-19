/*!
    @file     sigfox.cpp
    @author   Philippe SIMIER (Touchard Wahington le Mans)
    @license  BSD (see license.txt)
    @brief    Programme pour envoyer les data sur le middlewar Sigfox
    @date     18 Juillet 2020
    @version  v1.0 - first release
    @detail   Compilation  : g++  sigfox.cpp serie.c SimpleIni.cpp i2c.cpp  bme280.cpp hx711.cpp bh1750.cpp spi.c -o sigfox
              Execution    : ./sigfox
	     Installation  : cp sigfox /opt/Ruche/bin/sigfox
*/

#include <iostream>
#include <iomanip>
#include "serie.h"

using namespace std;

int main(int argc, char *argv[])
{

    int fdSerie;
    char message[100];
    char device[]="/dev/ttyS0";

    float temp = 35.67;
    short field1 = (short)(temp * 10);

    fdSerie = ouvrirPort(device);
    configurerSerie(fdSerie, 9600, NOECHO);

    cout << setfill ('0');
    cout << "AT$SF=";
    cout << hex << setw(4) << field1 << endl;

    envoyerMessage(fdSerie,"AT$SF=0400\n");
    recevoirMessage(fdSerie, message, '\n');
    printf("%s", message);

    fermerPort(fdSerie);
    return 0;
}

