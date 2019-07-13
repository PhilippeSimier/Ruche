#ifndef HX711_H_INCLUDED
#define HX711_H_INCLUDED

#include <iostream>
#include <stdlib.h>
#include <unistd.h>
#include <vector>
#include <algorithm>
#include "spi.h"


class hx711
{

public:

    // le constructeur
    hx711(float scale = 1.0);
    // le destructeur
    ~hx711();
    // Méthode pour obtenir la valeur du poids
    float obtenirPoids(int nb = 11);
    // Méthode pour effectuer le tarage
    void  effectuerTarage();
    // Méthode pour obtenir la valeur brute
    int   obtenirValeur();
    // Méthode pour fixer l'échelle de mesure (nb de points par unité de mesure)
    void fixerEchelle(float _scale);
    // Méthode pour fixer l'offset (décalage d'origine)
    void fixerOffset(int _offset);
    // Méthode pour obtenir l'offset
    int obtenirOffset();
    // Méthode pour fixer le gain de l'amplificateur
    // Prends effet après la prochaine lecture
    // channel A can be set for a 128 or 64 gain; channel B has a fixed 32 gain
    void configurerGain(char gain);
    // Méthode pour fixer le facteur de correction de température
    void fixerSlope(float _slope);
    // Méthode pour fixer la temérature de référence
    void fixerTempRef(float _tempRef);
    // Méthode pour obtenir le poids corrigé en fct de la températue
    float obtenirPoidsCorrige(float temp);
    // Méthode pour obtenir la moyenne et la variance de la dernière série
    float obtenirMoyenne();
    float obtenirVariance();

private:

    spi_t   spi;
    int     valeurBrute;
    int     offset;
    float   scale;
    float   tempRef;
    float   slope;
    unsigned char bufferEmission[7];
    float   moyenne;
    float   variance;
    float   calculerMoyenne(const std::vector<float> &t);
    float   calculerVariance(const std::vector<float> &t);
};

#endif // HX711_H_INCLUDED
