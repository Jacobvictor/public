const int buttonPin = 9;
int buttonState;                // the current reading from the input pin
int lastButtonState = LOW;
int led1 = 2;
int led2 = 3;
int led3 = 4;
int led4 = 5;
int ledIndex = 0;               // Index to track which LED to light up
int ledStates[4] = {LOW, LOW, LOW, LOW};  // Array to store LED states
unsigned long lastDebounceTime = 0;  // the last time the output pin was toggled
unsigned long debounceDelay = 50;    // the debounce time; increase if the output flickers
unsigned long countStartTime = 0;     // time when counting starts
int buttonPressCount = 0;             // count of button presses within 5 seconds
bool reverseOrder = false;            // Flag to track reverse order LED lighting

void setup() {
  Serial.begin(9600);
  Serial.println("initializing LED...");
  pinMode(led1, OUTPUT);
  pinMode(led2, OUTPUT);
  pinMode(led3, OUTPUT);
  pinMode(led4, OUTPUT);
  pinMode(buttonPin, INPUT);
  for (int i = 0; i < 4; i++) {
    digitalWrite(i + 2, ledStates[i]);
  }
}

void loop() {
  int reading = digitalRead(buttonPin);

  // Check if the button state has changed
  if (reading != lastButtonState) {
    // Reset the debouncing timer
    lastDebounceTime = millis();
  }

  if ((millis() - lastDebounceTime) > debounceDelay) {
    // If the reading has been stable for longer than debounce delay
    if (reading != buttonState) {
      buttonState = reading;

      // If the new button state is HIGH, toggle the LED and count the press
      if (buttonState == HIGH) {
        countStartTime = millis(); // Start counting time
        buttonPressCount++;        // Increment button press count
        if (buttonPressCount == 1) { // Check for single click
          // Turn off all LEDs
          for (int i = 0; i < 4; i++) {
            ledStates[i] = LOW;
            digitalWrite(i + 2, ledStates[i]);
          }
          // Sequentially light up each LED one at a time
          for (int i = 0; i < 4; i++) {
            ledStates[i] = HIGH;
            digitalWrite(i + 2, ledStates[i]);
            delay(500); // Adjust delay as needed
            ledStates[i] = LOW;
            digitalWrite(i + 2, ledStates[i]);
          }
        } else if (buttonPressCount == 2) { // Check for double click
          // Turn on all LEDs simultaneously
          for (int i = 0; i < 4; i++) {
            ledStates[i] = HIGH;
            digitalWrite(i + 2, ledStates[i]);
          }
        } else if (buttonPressCount == 3) { // Check for triple click
          // Reverse the order of LED lighting
          reverseOrder = true;
          // Turn off all LEDs
          for (int i = 0; i < 4; i++) {
            ledStates[i] = LOW;
            digitalWrite(i + 2, ledStates[i]);
          }
          // Sequentially light up each LED in reverse order
          for (int i = 3; i >= 0; i--) {
            ledStates[i] = HIGH;
            digitalWrite(i + 2, ledStates[i]);
            delay(500); // Adjust delay as needed
            ledStates[i] = LOW;
            digitalWrite(i + 2, ledStates[i]);
          }
          // Reset reverse order flag
          reverseOrder = false;
        }
      }
    }
  }

  // Update last button state
  lastButtonState = reading;

  // If 5 seconds elapsed since last button press, reset count
  if (millis() - countStartTime >= 3000) {
    Serial.print("Button press count in last 5 seconds: ");
    Serial.println(buttonPressCount);
    buttonPressCount = 0; // Reset count
  }

 
}
