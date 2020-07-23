/**
    @file       sigfox.cpp
    @authors    Philippe SIMIER (Touchard Wahington le Mans)
    @licence    BSD (see license.txt)
    @brief      Classe pour communiquer sur sigfox
    @version    v1.0 - First release
*/

#include "sigfox.h"



using namespace std;


Sigfox::Sigfox(const string _device, const bool _debug):
    device(_device),
    debug(_debug)
{
    fdSerie = ouvrirPort(device.c_str());
    configurerSerie(fdSerie, 9600, NOECHO);
}

Sigfox::~Sigfox()
{
    fermerPort(fdSerie);
}

string Sigfox::envoyer(const void* data, uint8_t size)
{
    ostringstream trameHexa;
    short octet;
    uint8_t *byte = (uint8_t*)data;

    trameHexa << setfill ('0');
    trameHexa << "AT$SF=";
    trameHexa << hex;
    for( int i=0; i< size; i++){
        octet = *byte;
        trameHexa << setw(2) << octet;
        byte++;
    }
    trameHexa << '\n';
    if(debug){
    	cout << trameHexa.str() << endl;
    }
    envoyerMessage(fdSerie,trameHexa.str().c_str());
    recevoirMessage(fdSerie, message, '\n');
    string retour(message);
    return retour;
}
