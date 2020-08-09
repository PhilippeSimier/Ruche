/*

    @date     18 Juillet 2020
    @version  v1.0 - first release
    @detail   Programme test unitaire classe Sigfox
              Compilation  : g++  main.cpp sigfox.cpp serie.c -o main
              Execution    : ./main


*/

#include <iostream>
#include <string>
#include "sigfox.h"

typedef struct {
    short field1;
    short field2;
    short field3;
    short field5;
    short field6;
    unsigned char  field4;
    unsigned char  type;
} trame;

using namespace std;

int main(void)
{

    trame t;
    Sigfox device("/dev/ttyS0", true);

    // test du fct composant
    cout << "test : " << device.tester() << endl;
    // Affichage de l'identifiant
    cout << "Sigfox ID : " << device.obtenirID() << endl;
    // Affichage du PAC number
    cout << "PAC : " << device.obtenirPAC() << endl;

    t.field1 = 12501;
    t.field2 = 5011;
    t.field3 = 10249;
    t.field4 = 64;
    t.field5 = 48214;
    t.field6 = 2031;
    t.type   = 3;

    cout << device.envoyer((void*)&t,12) << endl;

    return 0;
}
