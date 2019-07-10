#include "rest.h"
#include <curl/curl.h>
#include <curl/easy.h>
//#include <curl/curlbuild.h>
#include <sstream>
#include <iostream>

using namespace std;

size_t write_data(void *ptr, size_t size, size_t nmemb, void *stream) {
    string data((const char*) ptr, (size_t) size * nmemb);
    *((stringstream*) stream) << data << endl;
    return size * nmemb;
}

rest::rest() {
    curl = curl_easy_init();
}

rest::~rest() {
    curl_easy_cleanup(curl);
}

/**
 *  @brief methode GET
 *  @param string  l'URL du serveur
 *  @return long HTTP status code of 200 if successful. 
 */

long rest::get(const std::string& url) {
    curl_easy_setopt(curl, CURLOPT_URL, url.c_str());
    curl_easy_setopt(curl, CURLOPT_FOLLOWLOCATION, 1L);
    curl_easy_setopt(curl, CURLOPT_NOSIGNAL, 1);
    curl_easy_setopt(curl, CURLOPT_ACCEPT_ENCODING, "deflate");

    struct curl_slist *headers = NULL;
    headers = curl_slist_append(headers, "Cache-Control: no-cache");
    curl_easy_setopt(curl, CURLOPT_HTTPHEADER, headers);

    std::stringstream out;
    curl_easy_setopt(curl, CURLOPT_WRITEFUNCTION, write_data);
    curl_easy_setopt(curl, CURLOPT_WRITEDATA, &out);
    /* Perform the request, res will get the return code */
    CURLcode res = curl_easy_perform(curl);
    /* Check for errors */
    if (res != CURLE_OK) {
        cerr << "Failed : " << curl_easy_strerror(res) << endl;
    }
    response = out.str();
    long response_code;
    curl_easy_getinfo(curl, CURLINFO_RESPONSE_CODE, &response_code);
    return response_code;

}

/**
 *  @brief retourne un message explicitant le code de retour
 *  @param long HTTP status code le code de réponse revoyer par le serveur
 *  @return string message d'erreur pour thingSpeak
 */
std::string rest::getErreurServeur(const long statusCode){

    stringstream erreurServeur;

    erreurServeur << statusCode;
    switch(statusCode)
    {
	case 200:
            erreurServeur << " - OK Success";
            break;

        case 201:
            erreurServeur << " - Invalid field number specified";
            break;

        case 210:
            erreurServeur << " - setField() was not called before writeFields()";
            break;

        case 301:
            erreurServeur << " - Failed to connect to ThingSpeak";
            break;

        case 302:
            erreurServeur << " - Unexpected failure during write to ThingSpeak";
            break;

        case 303:
            erreurServeur << " - Unable to parse response";
            break;

        case 304:
            erreurServeur << " - Timeout waiting for server to respond";
            break;


        case 400:
            erreurServeur << " - Incorrect API key (or invalid server address)";
            break;

        case 401:
            erreurServeur << " - Point was not inserted (most probable cause is the rate limit of once every 15 seconds)";
            break;

        case 403:
            erreurServeur << " - Forbidden";
            break;

	case 404:
	    erreurServeur << " - Incorrect API key (or invalid server address)";
            break;

        case 500:
	    erreurServeur << " - Internal Server Error";
            break;

        case 501:
            erreurServeur << " - Not Implemented";
            break;

        case 502:
            erreurServeur << " - Bad Gateway";
            break;

        case 503:
            erreurServeur << " - Service Unavailable";
            break;

        case 504:
            erreurServeur << " - Gateway Timeout";
            break;

        case 505:
            erreurServeur << " - HTTP Version Not Supported";
            break;

        default:
            erreurServeur << " - unknow error";
    }
    return erreurServeur.str();
}

std::string rest::getResponse(){

    return response;
}

