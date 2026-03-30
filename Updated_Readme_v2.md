# PRAVESH: Smart RFID Entry and Exit System for Campus Management

PRAVESH is a smart campus entry and exit system that replaces handwritten registers with RFID-based digital logging. It uses Arduino UNO R4 WiFi, an RC522 RFID reader, a PHP backend, and a MySQL database to record student movement quickly and accurately.

The goal of this project is to make entry and exit tracking faster, safer, and easier for both students and administrators. It also adds email-based visit details, so the system stores not only who entered or exited, but also why and for how long.

![PRAVESH Project Cover](https://raw.githubusercontent.com/The-Harsh-Vardhan/PRAVESH-Smart_Entry-Exit_System/main/Pravesh%20Title%20Image.png)

## Video demonstration

Watch the project working here: [PRAVESH demo video on YouTube](https://youtu.be/vyVivCF2l8Y?si=cmd3QmNAOQZfWhCp)

## Why I built this project

In many schools and colleges, entry and exit records are still written by hand. This process takes time and often creates problems such as missing entries, unclear handwriting, delayed checking, and no real-time monitoring.

I built PRAVESH to solve this problem with a low-cost and practical digital system. A student only needs to scan an RFID card. The system then logs the event, updates the database, and helps the administration track movement in a simple way.

## Main features

- RFID-based identification using cards or tags
- Wi-Fi enabled logging using Arduino UNO R4 WiFi
- Real-time data transfer to a PHP backend
- MySQL storage for entry and exit records
- Email form for visit reason and expected return time
- Web dashboard for user management and log monitoring
- Excel export for reports

## Components used

- Arduino UNO R4 WiFi
- RC522 RFID card reader module
- RFID cards and key tags
- LCD1602 display with I2C interface
- RGB LED
- 5V passive buzzer
- 10K ohm resistor
- Jumper wires
- Breadboard

## How I built it

### Step 1: Designed the hardware connection

I started by selecting the Arduino UNO R4 WiFi as the main controller because it supports Wi-Fi communication directly. I connected the RC522 RFID module for card scanning, the LCD for status messages, and the RGB LED with buzzer for user feedback.

Important connections:

- RFID `SDA` to Arduino pin `10`
- RFID `SCK` to Arduino pin `13`
- RFID `MOSI` to Arduino pin `11`
- RFID `MISO` to Arduino pin `12`
- RFID `RST` to Arduino pin `9`
- Buzzer to pin `5`
- LCD `SDA` to `A4`
- LCD `SCL` to `A5`

![PRAVESH Circuit Diagram](https://github.com/user-attachments/assets/98a0ec40-ed14-47a5-8481-313d653f8307)

### Step 2: Programmed the Arduino for Wi-Fi and RFID scanning

After the hardware setup, I programmed the Arduino to connect to Wi-Fi, wait for an RFID scan, read the UID, and send that UID to the server. The LCD shows the current status, and the LED colors help the user understand the system state.

- Red LED: Wi-Fi not connected
- Green LED: system ready
- Blue LED: card scanned and processing

The main job of the Arduino is to convert a physical RFID scan into a digital request for the backend.

```cpp
String postData = "uid=" + uid;
client.beginRequest();
client.post("/rfidattendance/test_data.php");
client.sendHeader("Content-Type", "application/x-www-form-urlencoded");
client.sendHeader("Content-Length", postData.length());
client.beginBody();
client.print(postData);
client.endRequest();
```

When the system is connected and ready, it shows this state on the device:

![System Ready](https://github.com/user-attachments/assets/f6ee5008-3b08-4061-ad30-850119d6ce29)

### Step 3: Built the backend and database

Next, I created the backend using PHP and MySQL. When the Arduino sends the UID, the backend checks which user the card belongs to and stores the log in the database.

The database stores:

- user name
- user email
- card UID
- entry and exit time
- reason for visit
- expected return time

### Step 4: Added the email form workflow

To make the project more useful than a simple attendance logger, I added an email form. After a scan, the system can send an email to the user and ask for the reason for visit and estimated return time. Once the form is submitted, the record is updated automatically.

![Email Form](https://github.com/user-attachments/assets/11fcc62a-ddb5-4044-9ebf-1434e3fe8b86)

### Step 5: Built the admin dashboard

I then created a web dashboard using HTML, CSS, JavaScript, PHP, and MySQL. The dashboard allows administrators to manage users and track all movement logs from one place.

The dashboard supports:

- admin login
- add, edit, and remove users
- view all users
- monitor entry and exit records
- export logs to Excel

![Users Log Dashboard](https://github.com/user-attachments/assets/76dac3b2-93f9-45c6-8326-bb412fe4c20c)

### Step 6: Tested the complete workflow

Finally, I tested the full cycle from RFID scan to database update. When a card is scanned, the system shows a wait message, sends the UID to the backend, updates the logs, and resets for the next user.

![RFID Scan in Progress](https://github.com/user-attachments/assets/c570e4f8-129a-48ab-b0cb-e4226a0298cf)

For the full working process, please watch the demo video: [YouTube project demonstration](https://youtu.be/vyVivCF2l8Y?si=cmd3QmNAOQZfWhCp)

## How the system works

1. The Arduino powers on and connects to Wi-Fi.
2. The LCD and LED show that the system is ready.
3. A student scans an RFID card.
4. The UID is sent to the server using HTTP POST.
5. The backend stores the entry in the database.
6. The user can receive an email form for visit details.
7. The admin dashboard shows the updated records.
8. The system becomes ready for the next scan.

## Result

PRAVESH reduces manual work and improves the accuracy of campus entry and exit tracking. It also gives administrators a better way to monitor student movement in real time. The project is simple to use, low in cost, and practical for schools, colleges, hostels, and similar institutions.

## Project links

- Source code: [GitHub repository](https://github.com/The-Harsh-Vardhan/PRAVESH-Smart_Entry-Exit_System)
- Demo video: [YouTube link](https://youtu.be/vyVivCF2l8Y?si=cmd3QmNAOQZfWhCp)

## Team

- Kaushik: Hardware design and Arduino development
- Harsh Vardhan: Full-stack development and system integration
