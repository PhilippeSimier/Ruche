CXX = g++
EXEC = etalonnage tarage tarageCGI scaleCGI balanceJson bddLog thingSpeakGET envoyerURL synchronisation testBalance weather battery batteryJson

all: $(EXEC)

# compilation du programme batteryJson
batteryJson: batteryJson.cpp ina219.o i2c.o SimpleIni.o
	$(CXX) batteryJson.cpp ina219.o i2c.o SimpleIni.o -o batteryJson

# compilation du programme battery
battery: battery.cpp ina219.o i2c.o SimpleIni.o
	$(CXX) battery.cpp ina219.o i2c.o SimpleIni.o -o battery

# compilation du programme weather
weather: weather.cpp rest.o
	$(CXX) weather.cpp rest.o -lcurl -o weather

# compilation du programme envoyerURL
envoyerURL:   envoyerURL.cpp rest.o
	$(CXX) envoyerURL.cpp rest.o -lcurl -o envoyerURL

# compilation du programme bddLog
bddLog: bddLog.cpp SimpleIni.o hx711.o spi.o  bh1750.o bme280.o i2c.o
	$(CXX) bddLog.cpp SimpleIni.o hx711.o spi.o  bme280.o bh1750.o i2c.o -lmysqlcppconn -o bddLog

# compilation du programme etalonnage balance
etalonnage: etalonnage.cpp SimpleIni.o hx711.o
	$(CXX) etalonnage.cpp SimpleIni.o hx711.o spi.o -o etalonnage

# compilation du programme tarage balance
tarage: tarage.cpp SimpleIni.o hx711.o
	$(CXX) tarage.cpp SimpleIni.o hx711.o spi.o -o tarage

# compilation du programme tarageCGI balance
tarageCGI: tarageCGI.cpp SimpleIni.o hx711.o
	$(CXX) tarageCGI.cpp SimpleIni.o hx711.o spi.o -o tarageCGI

# compilation du programme scaleCGI balance
scaleCGI: scaleCGI.cpp SimpleIni.o hx711.o
	$(CXX) scaleCGI.cpp SimpleIni.o hx711.o spi.o -o scaleCGI


# compilation du programme balanceJson
balanceJson: balanceJson.cpp SimpleIni.o hx711.o
	$(CXX) balanceJson.cpp SimpleIni.o hx711.o spi.o -o balanceJson

# compilation du programme testBalance
testBalance: testBalance.cpp SimpleIni.o hx711.o
	$(CXX) testBalance.cpp SimpleIni.o hx711.o spi.o -o testBalance

# compilation de la classe  rest
rest.o: rest.cpp rest.h
	$(CXX) -c rest.cpp -o rest.o

# compilation de la classe SimpleIni
SimpleIni.o: SimpleIni.cpp SimpleIni.h
	$(CXX) -c SimpleIni.cpp -o SimpleIni.o

# compilation de la classe ina219
ina219.o: ina219.cpp ina219.h i2c.o
	$(CXX) -c ina219.cpp -o ina219.o

# compilation de la classe bme280
bme280.o: bme280.cpp bme280.h i2c.o
	$(CXX) -c bme280.cpp -o bme280.o

# compilation de la classe hx711
hx711.o: hx711.cpp hx711.h spi.o
	$(CXX) -c hx711.cpp -o hx711.o

# compilation de la classe bh1750
bh1750.o: bh1750.cpp bh1750.h i2c.o
	$(CXX) -c bh1750.cpp -o bh1750.o


# compilation de spi
spi.o: spi.c spi.h
	$(CXX) -c spi.c -o spi.o

# compilation de le classe i2c
i2c.o: i2c.cpp i2c.h
	$(CXX) -c i2c.cpp -o i2c.o

.PHONY: clean mrproper

# suppression des fichiers temporaires
clean:
	rm -rf *.o

# pour la reconstruction du projet
mrproper: clean
	rm $(EXEC)


install:

# Install les programmes CGI
	cp balanceJson /usr/lib/cgi-bin/balanceJson
	chmod +s /usr/lib/cgi-bin/balanceJson
	cp tarageCGI /usr/lib/cgi-bin/tarageCGI
	chmod +s /usr/lib/cgi-bin/tarageCGI
	cp scaleCGI /usr/lib/cgi-bin/scaleCGI
	chmod +s /usr/lib/cgi-bin/scaleCGI
	cp batteryJson /usr/lib/cgi-bin/batteryJson
	chmod +s /usr/lib/cgi-bin/batteryJson

# Install les fichier pour le site Web
	mkdir -p /var/www/html/Ruche
	cp -a /home/pi/Ruche/html/* /var/www/html/Ruche/
	cp -a /home/pi/Ruche/html/.htaccess /var/www/html/Ruche/

# Install les fichiers exécutables dans /opt/Ruche/bin/
# Install les fichiers de configuration dans /opt/Ruche/etc/
# Install les fichiers de log dans /var/log/Ruche/
	mkdir -p /opt/Ruche
	mkdir -p /opt/Ruche/bin
	mkdir -p /opt/Ruche/etc
	mkdir -p /var/log/Ruche
	cp bddLog /opt/Ruche/bin/bddLog
#	cp thingSpeakGET /opt/Ruche/bin/thingSpeakGET
	cp envoyerURL /opt/Ruche/bin/envoyerURL
	cp synchronisation /opt/Ruche/bin/synchronisation
	cp weather /opt/Ruche/bin/weather
	cp battery /opt/Ruche/bin/battery
	cp coulombCounter /opt/Ruche/bin/coulombCounter

config:
	cp ../configuration.ini /opt/Ruche/etc/configuration.ini
	chmod 777 /opt/Ruche/etc/configuration.ini
	cp ../battery.ini /opt/Ruche/etc/battery.ini
	chmod 777 /opt/Ruche/etc/battery.ini

apache:
	cp ../Raspbian_OS_Setup/apache2.conf /etc/apache2/apache2.conf
	systemctl restart apache2

uninstall:
	rm /usr/lib/cgi-bin/balanceJson
	rm /usr/lib/cgi-bin/tarageCGI
	rm /usr/lib/cgi-bin/scaleCGI

