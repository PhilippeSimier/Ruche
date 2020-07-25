/**
  * @file sigfox.h
  * @author Philippe SIMIER Touchard Washington
  * @date 23 juillet 2020
  * @details Communication avec le réseau Sigfox avec les commandes AT
  *
  */



#ifndef __SIGFOX__
#define __SIGFOX__

#include <iostream>
#include <string>
#include <iomanip>
#include <sstream>
#include "serie.h"

using namespace std;

class Sigfox
{
  public:

    Sigfox(const string _device, const bool _debug);
    ~Sigfox();
    string   tester(void);
    string   obtenirID(void);
    string   obtenirPAC(void);
    uint16_t obtenirTemp(void);

    string   envoyer(const void* data, uint8_t size);

  private:
    string device;
    bool debug;
    int fdSerie;
    char message[100];
};

#endif

