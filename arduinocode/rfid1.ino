#include <SPI.h>
#include <Ethernet.h>
#define BUFFSIZ 90

//RFID parser
char buffer_RFID[BUFFSIZ];
char buffidx_RFID;
char response_str[64];
byte mac[] = {  0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
IPAddress server(192,168,1,2);
char command_scantag[]={0x31,0x03,0x01};//const
unsigned char  incomingByte;
EthernetClient client;
unsigned char parsed_okay=0;
String reply = "GET /rfid/process.php?i=";
unsigned char tag_found_number;
char hello;
char inString[32]; // string for incoming serial data
int stringPos = 0; // string index counter
boolean startRead = false; // is reading?

unsigned int bytecount=0;
int led = 13;
int led1 = 8;
// initialize the library with the numbers of the interface pins
//LiquidCrystal lcd(12, 11, 5, 4, 3, 2);

void setup(){
  pinMode(led, OUTPUT);  
  pinMode(led1, OUTPUT);
  parsed_okay=0;
  
  // set up the LCD's number of columns and rows: 
  //lcd.begin(16, 2);
  // Print a message to the LCD.
  //lcd.print("Xbee UHFRFID Reader");
  reply.reserve(256);
  Serial.begin(9600);
  Serial1.begin(115200);
  if (Ethernet.begin(mac) == 0) {
    Serial.println("Failed to configure Ethernet using DHCP");
    // no point in carrying on, so do nothing forevermore:
    for(;;)
      ;
  }
  
  if (client.connect(server, 80)) {
    Serial.println("connected");
    // Make a HTTP request:
    client.println("GET /rfid/process.php?i=999");
    client.println();
  } 
  else {
    // kf you didn't get a connection to the server:
    Serial.println("connection failed");
  }
  //Serial.println("Test Xbee Connection");
  
}

void loop() 
{
    
  Serial1.print(command_scantag);
  int sum=0;
  delay(500);  
  while(Serial1.available())
  {
    incomingByte = Serial1.read();
    //Serial.println(incomingByte);
    sum+=incomingByte;
    }
    Serial.println(sum);
    Serial.println("blank");
      if(sum>54) {
        //Serial.println("sending");
        sendData(sum);
        //Serial.println("sent");
      }   
}

void sendData(int thisData) {
  // if there's a successful connection:
  if (client.connect(server, 80)) {
    // send the HTTP PUT request:
    client.print("GET /rfid/process.php?i=");
    client.print(thisData);
    //client.print(" HTTP/1.0");
    client.println();
    String response = readPage();
    Serial.println(response);
    if(response=="1"){
       digitalWrite(led, HIGH);   // turn the LED on (HIGH is the voltage level)
       delay(2000);               // wait for a second
       digitalWrite(led, LOW);    // turn the LED off by making the voltage LOW
    }else{
      digitalWrite(led1, HIGH);   // turn the LED on (HIGH is the voltage level)
       delay(2000);               // wait for a second
       digitalWrite(led1, LOW);    // turn the LED off by making the voltage LOW
      
    }
    
    //Serial.println(response);
  } 
  else {
    // if you couldn't make a connection:
                                        //    Serial.println("connection failed");
                                        //    Serial.println();
                                        //    Serial.println("disconnecting.");
    client.stop();
  }
  // note the time that the connection was made or attempted:
}

String readPage(){
  //read the page, and capture & return everything between '<' and '>'

  stringPos = 0;
  memset( &inString, 0, 32 ); //clear inString memory

  while(client.connected()){

    if (client.available()) {
      char c = client.read();

      if (c == '+' ) { //'<' is our begining character
        startRead = true; //Ready to start reading the part 
      }else if(startRead){

        if(c != '-'){ //'>' is our ending character
          inString[stringPos] = c;
          stringPos ++;
        }else{
          //got what we need here! We can disconnect now
          startRead = false;
          //delay(1);
          //client.stop();
          //client.flush();
          client.stop();
          return inString;

        }

      }
    }else{
		//return "0";
                //delay(1000);
	}

  }

}
