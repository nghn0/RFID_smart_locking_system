#include <SPI.h>
#include <MFRC522.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <ESP8266WiFi.h>


#define ssid "wifi_name"
#define password "wifi_password"


constexpr uint8_t RST_PIN = D4;     // Configurable, see typical pin layout above
constexpr uint8_t SS_PIN = D8;     // Configurable, see typical pin layout above
MFRC522 rfid(SS_PIN, RST_PIN); // Instance of the class
MFRC522::MIFARE_Key key;

WiFiClient wcl;

String tag;

String URL = "https://yourwebsitehostingdomain/add_rfid_data.php";
String Link;

int lock=D0;

void http_connection(String card, String name);


void setup() {
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid,password);
  Serial.begin(9600);
  while(WiFi.status() != WL_CONNECTED){
    delay(500);
    Serial.print(".");
  }
  Serial.println("\n");
  Serial.print("Connected to :");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());
  pinMode(lock,OUTPUT);
  digitalWrite(lock, HIGH);
  SPI.begin(); // Init SPI bus
  rfid.PCD_Init(); // Init MFRC522
}
void loop() {
  if ( ! rfid.PICC_IsNewCardPresent())
    return;
  if (rfid.PICC_ReadCardSerial()) {
    for (byte i = 0; i < 4; i++) {
      tag += rfid.uid.uidByte[i];
    }
    if(tag=="2222274829")
    {
      Serial.print(tag);
      Serial.println(": Access granted");
      digitalWrite(lock, LOW);
      delay(3000);
      digitalWrite(lock, HIGH);
      http_connection(tag, "name"); // name in regards to the tagID
    }
    else{
        Serial.print(tag);
        Serial.println(": Access denied");
    }
    tag = "";

    rfid.PICC_HaltA(); 
    rfid.PCD_StopCrypto1();
    }

}

void http_connection(String card, String name)
{
  HTTPClient http;
  String getData = "?carduid=" + card + "&name=" + name;
  Link = URL + getData;
  Serial.println(Link);
  http.begin(wcl,Link);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  int httpCode = http.GET(); 
  Serial.println(httpCode);
  if(httpCode>0)
    Serial.println("Value added");
  http.end();
}












