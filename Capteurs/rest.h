#ifndef REST_H
#define REST_H

#include <string>

   /**
     * A non-threadsafe simple libcURL-easy based HTTP REST
     */
class rest {

    public:
    rest();
    ~rest();

   /**
     * Download a file using HTTP GET and store in response a std::string
     * @param url The URL to download
     * @return The HTTP Code (if success then 200)
     */
    long get(const std::string& url);

   /**
     * return the  error server in std::string
     * @param long the error code
     * @return string Code (if success then OK)
     */
    std::string getErreurServeur(long statusCode);

    std::string getResponse();

    private:
    void* curl;
    std::string response;
};

#endif  /* REST_H */
