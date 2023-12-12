CREATE TABLE HourlyRate (
ID INT PRIMARY KEY AUTO_INCREMENT,
HourlyRate VARCHAR(255) NOT NULL
);

CREATE TABLE Species (
ID INT PRIMARY KEY AUTO_INCREMENT,
Name VARCHAR(255) NOT NULL,
FoodCost INT NOT NULL
);

CREATE TABLE Building (
ID INT PRIMARY KEY AUTO_INCREMENT,
Name VARCHAR(255) NOT NULL,
Type VARCHAR(255) NOT NULL
);

CREATE TABLE RevenueType (
ID INT PRIMARY KEY AUTO_INCREMENT,
BuildingID INT,
Name VARCHAR(255) NOT NULL,
Type VARCHAR(255) NOT NULL,
FOREIGN KEY (BuildingID) REFERENCES Building(ID)
);

CREATE TABLE RevenueEvents (
ID INT,
DateTime DATE,
Revenue INT NOT NULL,
TicketsSold INT NOT NULL,
PRIMARY KEY(ID, DateTime),
FOREIGN KEY (ID) REFERENCES RevenueType(ID)
);

CREATE TABLE AnimalShow (
ID INT PRIMARY KEY,
ShowsPerDay INT NOT NULL,
SeniorPrice INT NOT NULL,
AdultPrice INT NOT NULL,
ChildPrice INT NOT NULL,
FOREIGN KEY (ID) REFERENCES RevenueType(ID)
);

CREATE TABLE Concession (
ID INT PRIMARY KEY,
Product VARCHAR(255) NOT NULL,
FOREIGN KEY (ID) REFERENCES RevenueType(ID)
);

CREATE TABLE ZooAdmission (
ID INT PRIMARY KEY,
SeniorPrice INT NOT NULL,
AdultPrice INT NOT NULL,
ChildPrice INT NOT NULL,
FOREIGN KEY (ID) REFERENCES RevenueType(ID)
);

CREATE TABLE ParticipatesIN (
SpeciesID INT,
AnimalShowID INT,
Reqd INT NOT NULL,
PRIMARY KEY(SpeciesID, AnimalShowID),
FOREIGN KEY (SpeciesID) REFERENCES Species(ID),
FOREIGN KEY (AnimalShowID) REFERENCES AnimalShow(ID)
);

CREATE TABLE Enclosure (
ID INT AUTO_INCREMENT,
BuildingID INT,
SqFt INT NOT NULL,
PRIMARY KEY(ID, BuildingID),
FOREIGN KEY (BuildingID) REFERENCES Building(ID)
);

CREATE TABLE Animal (
ID INT PRIMARY KEY AUTO_INCREMENT,
Status VARCHAR(255) NOT NULL,
BirthYear DATE NOT NULL,
SpeciesID INT,
EnclosureID INT,
BuildingID INT,
FOREIGN KEY (BuildingID) REFERENCES Building(ID),
FOREIGN KEY (SpeciesID) REFERENCES Species(ID),
FOREIGN KEY (EnclosureID) REFERENCES Enclosure(ID)
);

CREATE TABLE Employee (
EmployeeID INT PRIMARY KEY AUTO_INCREMENT,
StartDate VARCHAR(255) NOT NULL,
JobType VARCHAR(255) NOT NULL,
FirstName VARCHAR(255) NOT NULL,
MiddleName VARCHAR(255),
LastName VARCHAR(255) NOT NULL,
Street VARCHAR(255) NOT NULL,
City VARCHAR(255) NOT NULL,
State VARCHAR(255) NOT NULL,
Zip VARCHAR(255) NOT NULL,
SuperID INT,
HourlyRateID INT,
ConcessionID INT,
ZooAdmissionID INT,
FOREIGN KEY (SuperID) REFERENCES Employee(EmployeeID),
FOREIGN KEY (HourlyRateID) REFERENCES HourlyRate(ID),
FOREIGN KEY (ConcessionID) REFERENCES Concession(ID),
FOREIGN KEY (ZooAdmissionID) REFERENCES ZooAdmission(ID)
);

CREATE TABLE CaresFor (
EmployeeID INT REFERENCES Employee(EmployeeID),
SpeciesID INT REFERENCES Species(ID),
PRIMARY KEY(EmployeeID, SpeciesID),
FOREIGN KEY (EmployeeID) REFERENCES Employee(EmployeeID),
FOREIGN KEY (SpeciesID) REFERENCES Species(ID)
);

CREATE TABLE zooadmissiontickets (
  TicketID int(11) NOT NULL AUTO_INCREMENT,
  ZooAdmissionID int(11) DEFAULT NULL,
  AdultTickets int(11) NOT NULL,
  ChildTickets int(11) NOT NULL,
  SeniorTickets int(11) NOT NULL,
  Price decimal(10,2) NOT NULL,
  Attendance int(11) NOT NULL,
  Revenue decimal(10,2) NOT NULL,
  CheckoutTime timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (TicketID),
  FOREIGN KEY (ZooAdmissionID) REFERENCES zooadmission(ID)
);

CREATE TABLE animalshowtickets (
  TicketID int(11) NOT NULL AUTO_INCREMENT,
  AnimalShowID int(11) DEFAULT NULL,
  AdultTickets int(11) NOT NULL,
  ChildTickets int(11) NOT NULL,
  SeniorTickets int(11) NOT NULL,
  Price decimal(10,2) NOT NULL,
  Attendance int(11) NOT NULL,
  Revenue decimal(10,2) NOT NULL,
  CheckoutTime timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (TicketID),
  FOREIGN KEY (AnimalShowID) REFERENCES ANIMALSHOW(ID)
) ;

CREATE TABLE dailyconcessionrevenue (
  RecordID int(11) NOT NULL AUTO_INCREMENT,
  ConcessionID int(11) DEFAULT NULL,
  Revenue decimal(10,2) NOT NULL,
  SaleDate date NOT NULL DEFAULT curdate(),
  PRIMARY KEY (RecordID),
  FOREIGN KEY (ConcessionID) REFERENCES Concession(ID)
);
CREATE TABLE users (
  UserID int(11) NOT NULL AUTO_INCREMENT,
  Username varchar(255) NOT NULL,
  Password varchar(255) NOT NULL,
  Role varchar(50) NOT NULL,
  PRIMARY KEY (UserID)
);