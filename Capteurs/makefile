CXX = g++
EXEC = etalonnage tarage tarageCGI scaleCGI balanceJson bddLog thingSpeak synchronisation testBalance

all: $(EXEC)

# compilation du programme synchronisation
synchronisation: synchronisation.cpp SimpleIni.o
	$(CXX) synchronisation.cpp -lmysqlcppconn SimpleIni.o -o synchronisation 


# compilation du programme thingSpeak
thingSpeak: thingSpeak.cpp rest.o SimpleIni.o hx711.o bh1750.o spi.o bme280.o i2c.o
	$(CXX) thingSpeak.cpp rest.o SimpleIni.o hx711.o bme280.o bh1750.o spi.o i2c.o -lcurl -o thingSpeak

# compilation du programme bddLog
bddLog: bddLog.cpp SimpleIni.o hx711.o spi.o  bh1750.o bme280.o i2c.o 
	$(CXX) bddLog.cpp SimpleIni.o hx711.o spi.o  bme280.o bh1750.o i2c.o -lmysqlcppconn -o bddLog

# compilation du programme etalonnage 
etalonnage: etalonnage.cpp SimpleIni.o hx711.o
	$(CXX) etalonnage.cpp SimpleIni.o hx711.o spi.o -o etalonnage

# compilation du programme tarage
tarage: tarage.cpp SimpleIni.o hx711.o
	$(CXX) tarage.cpp SimpleIni.o hx711.o spi.o -o tarage

# compilation du programme tarageCGI
tarageCGI: tarageCGI.cpp SimpleIni.o hx711.o
	$(CXX) tarageCGI.cpp SimpleIni.o hx711.o spi.o -o tarageCGI

# compilation du programme scaleCGI
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

# Install les programmes CGI
install:
	cp balanceJson /usr/lib/cgi-bin/balanceJson
	chmod +s /usr/lib/cgi-bin/balanceJson
	cp tarageCGI /usr/lib/cgi-bin/tarageCGI
	chmod +s /usr/lib/cgi-bin/tarageCGI
	cp scaleCGI /usr/lib/cgi-bin/scaleCGI
	chmod +s /usr/lib/cgi-bin/scaleCGI
	mkdir /var/www/html/Ruche
	cp -a /home/pi/Ruche/html/* /var/www/html/Ruche/
	cp -a /home/pi/Ruche/html/.htaccess /var/www/html/Ruche/
#	sudo mv /home/pi/Ruche/configuration.ini.default /home/pi/Ruche/configuration.ini

uninstall:
	rm /usr/lib/cgi-bin/balanceJson
	rm /usr/lib/cgi-bin/tarageCGI
	rm /usr/lib/cgi-bin/scaleCGI

