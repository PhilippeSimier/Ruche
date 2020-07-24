/**
    @file       sigfox.cpp
    @authors    Philippe SIMIER (Touchard Wahington le Mans)
    @licence    BSD (see license.txt)
    @brief      Classe pour communiquer sur sigfox
    @version    v1.0 - First release
*/

#include "sigfox.h"



using namespace std;

/* Le constructeur
   Ouvre le port série et le configure à 9600bauds
*/
Sigfox::Sigfox(const string _device, const bool _debug):
    device(_device),
    debug(_debug)
{
    fdSerie = ouvrirPort(device.c_str());
    configurerSerie(fdSerie, 9600, NOECHO);
}

/* Le destructeur
   Ferme le port série
*/
Sigfox::~Sigfox()
{
    fermerPort(fdSerie);
}

/* Méthode pour envoyer n octets en mémoire
   retourne "OK" lorsque le message est envoyé
*/
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

/*
  Méthode pour tester la présence de l'emetteur Sigfox
  @return "OK" si le composant est présent
*/
string Sigfox::tester(void)
{
    string commande = "AT\n";
    envoyerMessage(fdSerie,commande.c_str());
    recevoirMessage(fdSerie, message, '\n');
    string retour(message);
    return retour;
}

/*
  Méthode pour obtenir l'identifiant de l'emetteur Sigfox
  @return un string l'identifiant
*/
string Sigfox::obtenirID(void)
{
    string commande = "AT$I=10\n";
    envoyerMessage(fdSerie,commande.c_str());
    recevoirMessage(fdSerie, message, '\n');
    string retour(message);
    return retour;
}
/*
  Méthode pour obtenir le PAC number de l'emetteur Sigfox
  @return un string contenant le PAC number
*/
string Sigfox::obtenirPAC(void)
{
    string commande = "AT$I=11\n";
    envoyerMessage(fdSerie,commande.c_str());
    recevoirMessage(fdSerie, message, '\n');
    string retour(message);
    return retour;
}

