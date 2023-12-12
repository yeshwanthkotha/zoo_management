INSERT INTO HourlyRate (HourlyRate) VALUES ('20.00'), ('25.00'), ('30.00');

INSERT INTO Species (Name, FoodCost) VALUES ('Elephant', 500), ('Tiger', 300), ('Penguin', 100);

INSERT INTO Building (Name, Type) VALUES ('Aquarium', 'Exhibit'), ('Aviary', 'Exhibit'), ('Restaurant', 'Facility');

INSERT INTO RevenueType (BuildingID, Name, Type) VALUES (1, 'Ticket Sales', 'Admission'), (3, 'Food Sales', 'Concession');

INSERT INTO RevenueEvents (ID, DateTime, Revenue, TicketsSold) VALUES (1, '2023-01-01', 1000, 50);

INSERT INTO AnimalShow (ID, ShowsPerDay, SeniorPrice, AdultPrice, ChildPrice) VALUES (1, 3, 15, 20, 10);

INSERT INTO Concession (ID, Product) VALUES (2, 'Ice Cream');

INSERT INTO ParticipatesIN (SpeciesID, AnimalShowID, Reqd) VALUES (2, 1, 1);

INSERT INTO Enclosure (BuildingID, SqFt) VALUES (1, 2000), (2, 1500);

INSERT INTO Animal (Status, BirthYear, SpeciesID, EnclosureID, BuildingID) VALUES ('Healthy', '2018-06-01', 1, 1, 1);

INSERT INTO Employee (StartDate, JobType, FirstName, LastName, Street, City, State, Zip, SuperID, HourlyRateID, ConcessionID, ZooAdmissionID) VALUES ('2023-01-01', 'Zookeeper', 'John', 'Doe', '123 Main St', 'Anytown', 'State', '12345', NULL, 1, NULL, NULL);

INSERT INTO CaresFor (EmployeeID, SpeciesID) VALUES (1, 1);

INSERT INTO ZooAdmission (ID, SeniorPrice, AdultPrice, ChildPrice) VALUES (1, 15, 20, 10);

INSERT INTO zooadmissiontickets (ZooAdmissionID, AdultTickets, ChildTickets, SeniorTickets, Price, Attendance, Revenue) VALUES (1, 2, 1, 1, 50.00, 4, 200.00);

INSERT INTO animalshowtickets (AnimalShowID, AdultTickets, ChildTickets, SeniorTickets, Price, Attendance, Revenue) VALUES (1, 3, 2, 1, 60.00, 6, 360.00);

INSERT INTO dailyconcessionrevenue (ConcessionID, Revenue, SaleDate) VALUES (2, 150.00, '2023-01-01');

INSERT INTO users (Username, Password, Role) VALUES ('admin', 'password', 'Administrator'), ('user', 'password', 'User');