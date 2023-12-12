-- Adding more hourly rates
INSERT INTO HourlyRate (HourlyRate) VALUES ('35.00'), ('40.00'), ('18.00');

-- Adding more species
INSERT INTO Species (Name, FoodCost) VALUES ('Lion', 400), ('Giraffe', 250), ('Zebra', 150);

-- Adding more buildings
INSERT INTO Building (Name, Type) VALUES ('Reptile House', 'Exhibit'), ('Education Center', 'Facility'), ('Gift Shop', 'Facility');

-- Adding more revenue types
INSERT INTO RevenueType (BuildingID, Name, Type) VALUES (2, 'Gift Sales', 'Retail'), (4, 'Workshop Fees', 'Education');

-- Adding more revenue events
INSERT INTO RevenueEvents (ID, DateTime, Revenue, TicketsSold) VALUES (2, '2023-01-02', 800, 40);

-- Adding more animal shows
#INSERT INTO AnimalShow (ID, ShowsPerDay, SeniorPrice, AdultPrice, ChildPrice) VALUES (2, 2, 12, 18, 8);

-- Adding more concession products
INSERT INTO Concession (ID, Product) VALUES (3, 'Soft Drinks');

-- More species participating in animal shows
INSERT INTO ParticipatesIN (SpeciesID, AnimalShowID, Reqd) VALUES (3, 2, 2);

-- Adding more enclosures
INSERT INTO Enclosure (BuildingID, SqFt) VALUES (3, 2500), (4, 1000);

-- Adding more animals
INSERT INTO Animal (Status, BirthYear, SpeciesID, EnclosureID, BuildingID) VALUES 
('Healthy', '2019-07-03', 2, 2, 2),
('In Care', '2020-03-15', 3, 3, 3);

-- Adding more employees
INSERT INTO Employee (StartDate, JobType, FirstName, LastName, Street, City, State, Zip, SuperID, HourlyRateID, ConcessionID, ZooAdmissionID) VALUES 
('2023-02-01', 'Retail Manager', 'Alice', 'Smith', '456 Park Ave', 'Cityville', 'State', '67890', NULL, 2, NULL, NULL),
('2023-02-15', 'Educator', 'Bob', 'Johnson', '789 Oak St', 'Townsville', 'State', '10112', NULL, 3, NULL, NULL);

-- More employees caring for species
INSERT INTO CaresFor (EmployeeID, SpeciesID) VALUES (2, 2), (3, 3);

-- More zoo admission details
INSERT INTO ZooAdmission (ID, SeniorPrice, AdultPrice, ChildPrice) VALUES (2, 10, 15, 5);

-- More zoo admission ticket sales
INSERT INTO zooadmissiontickets (ZooAdmissionID, AdultTickets, ChildTickets, SeniorTickets, Price, Attendance, Revenue) VALUES 
(2, 4, 3, 2, 70.00, 9, 630.00);

-- More animal show ticket sales
INSERT INTO animalshowtickets (AnimalShowID, AdultTickets, ChildTickets, SeniorTickets, Price, Attendance, Revenue) VALUES 
(2, 2, 3, 2, 50.00, 7, 350.00);

-- More daily concession revenue
INSERT INTO dailyconcessionrevenue (ConcessionID, Revenue, SaleDate) VALUES (3, 200.00, '2023-01-02');

-- More user accounts
INSERT INTO users (Username, Password, Role) VALUES 
('manager', 'securepassword', 'Manager'),
('staff', 'staffpassword', 'Staff');
