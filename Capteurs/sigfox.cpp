/**
    @file       sigfox.cpp
    @authors    Philippe SIMIER (Touchard Wahington le Mans)
    @licence    BSD (see license.txt)
    @brief      Classe pour communiquer avec le transmetteur sigfox BRKWS01
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
    retour = retour.substr(0, retour.length()-2);
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
    retour = retour.substr(0, retour.length()-2);
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
    retour = retour.substr(0, retour.length()-2);
    return retour;
}

/*
  Méthode pour obtenir la fréquence d'émission en MHz
  @return un float la frequence d'émission
*/

float Sigfox::obtenirFreqEmi(void){
    string commande = "AT$IF?\n";
    envoyerMessage(fdSerie,commande.c_str());
    recevoirMessage(fdSerie, message, '\n');
    string retour(message);
    retour = retour.substr(0, retour.length()-2);
    return stof(retour)/1e6;
}

/*
  Méthode pour obtenir la fréquence de reception en MHz
  @return un float la frequence de reception
*/

float Sigfox::obtenirFreqRec(void){
    string commande = "AT$DR?\n";
    envoyerMessage(fdSerie,commande.c_str());
    recevoirMessage(fdSerie, message, '\n');
    string retour(message);
    retour = retour.substr(0, retour.length()-2);
    return stof(retour)/1e6;
}

/*
  Méthode pour obtenir la température du composant
  @return un float la température en °C
*/

float Sigfox::obtenirTemp(void){
    string commande = "AT$T?\n";
    envoyerMessage(fdSerie,commande.c_str());
    recevoirMessage(fdSerie, message, '\n');
    string retour(message);
    retour = retour.substr(0, retour.length()-2);
    return stof(retour)/10;
}

/*
    Return current voltage and voltage measured during the last
    transmission in V.
*/

void Sigfox::obtenirTension(float &tension0, float &tension1){

    string commande = "AT$V?\n";
    envoyerMessage(fdSerie,commande.c_str());
    // lecture de la tension courante
    recevoirMessage(fdSerie, message, '\n');
    string retour(message);
    retour = retour.substr(0, retour.length()-2);
    tension0 = stof(retour)/1e3;

    // lecture de la tension au cours de la dernière emission
    recevoirMessage(fdSerie, message, '\n');
    string retour1(message);
    retour1 = retour1.substr(0, retour1.length()-2);
    tension1 = stof(retour1)/1e3;
}

