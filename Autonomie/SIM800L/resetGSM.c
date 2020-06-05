/* Programme pour réinitialiser le modem GSM SIM800L
   après redémarage du Rpi
   Compilation : gcc -Wall resetGSM.c -lwiringPi -o resetGSM
*/

#include <stdio.h>
#include <unistd.h>
#include <wiringPi.h>

int main (void)
{
    wiringPiSetupGpio();
    pinMode(18, OUTPUT);
    digitalWrite(18, 1);
    sleep(30);
    digitalWrite(18, 0);
    delay(500);
    digitalWrite(18, 1);
    printf("reset done\n");
    return 0;
}
