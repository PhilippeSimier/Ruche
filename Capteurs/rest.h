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

    private:
    void* curl;
    std::string response;
};

#endif  /* REST_H */
