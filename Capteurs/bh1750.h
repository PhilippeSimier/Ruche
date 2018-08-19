#ifndef BH1750_H_INCLUDED
#define BH1750_H_INCLUDED

#include "i2c.h"
#include <unistd.h>

#define ADRESSE_I2C_BH1750 0x23  // adresse I2C par défaut pour bh1750

// No active state
#define BH1750_POWER_DOWN 0x00

// Wating for measurment command
#define BH1750_POWER_ON 0x01

// Reset data register value - not accepted in POWER_DOWN mode
#define BH1750_RESET 0x07

// Start measurement at 1lx resolution. Measurement time is approx 120ms.
#define BH1750_CONTINUOUS_HIGH_RES_MODE  0x10

// Start measurement at 0.5lx resolution. Measurement time is approx 120ms.
#define BH1750_CONTINUOUS_HIGH_RES_MODE_2  0x11

// Start measurement at 4lx resolution. Measurement time is approx 16ms.
#define BH1750_CONTINUOUS_LOW_RES_MODE  0x13

// Start measurement at 1lx resolution. Measurement time is approx 120ms.
// Device is automatically set to Power Down after measurement.
#define BH1750_ONE_TIME_HIGH_RES_MODE  0x20

// Start measurement at 0.5lx resolution. Measurement time is approx 120ms.
// Device is automatically set to Power Down after measurement.
#define BH1750_ONE_TIME_HIGH_RES_MODE_2  0x21

// Start measurement at 1lx resolution. Measurement time is approx 120ms.
// Device is automatically set to Power Down after measurement.
#define BH1750_ONE_TIME_LOW_RES_MODE  0x23


class bh1750
{
    public:
    // le constructeur
    bh1750(int i2cAddress=ADRESSE_I2C_BH1750);
    // le destructeur
    ~bh1750();
    // méthode pour lire la valeur de l'éclairement
    float obtenirLuminosite_Lux();
    // méthode pour configurer le mode
    void configurer(int mode=BH1750_ONE_TIME_HIGH_RES_MODE_2);
    void activer(void);
    void desactiver(void);
    void reset(void);


    private:
    i2c *deviceI2C;
    float resolution;

};

#endif // BH1750_H_INCLUDED
