/*

    @date     18 Juillet 2020
    @version  v1.0 - first release
    @detail   Programme test unitaire classe Sigfox
              Compilation  : g++  main3.cpp sigfox.cpp serie.c -o main3
              Execution    : ./main3


*/

#include <iostream>
#include <string>
#pragma pack(1)
#include "sigfox.h"

typedef struct {
    short field1;
    short field2;
    short field3;
    unsigned char  field4;
    short field5;
    short field6;
    unsigned char  type;
} trame;

using namespace std;

int main(int argc, char *argv[])
{

    trame t;
    Sigfox device("/dev/ttyS0", true);

    t.field1 = 12500;
    t.field2 = 5010;
    t.field3 = 10248;
    t.field4 = 65;
    t.field5 = 48214;
    t.field6 = 2030;
    t.type   = 1;

    cout << device.envoyer((void*)&t,12) << endl;

    return 0;
}
