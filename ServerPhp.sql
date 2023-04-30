

-- Creating PHP apps using Microsoft SQL Server 2002 
-- DEVELOPER EDITION on Windows and xampp control panel

-- query to create database SamplePHP
CREATE DATABASE SamplePHP;
USE SamplePHP;

-- query to create table Employees
CREATE TABLE Employees
(
  Id INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
  Name NVARCHAR(50),
  Location NVARCHAR(50)
);

-- query to insert values to table Employees
INSERT INTO Employees
  (Name, Location)
VALUES
  (N'Uchefuna', N'Southend'),
  (N'Dragos', N'London'),
  (N'Grace', N'Leigh'),
  (N'Franc', N'Basildon'),
  (N'Joe', N'Stratford'),
  (N'Malik', N'Luton'),
  (N'Peter', N'Tilbury'),
  (N'Neil', N'Southend'),
  (N'Liz', N'Stratford'),
  (N'Sam', N'Grays');

-- SET IDENTITY_INSERT to ON.  
-- SET IDENTITY_INSERT Employees ON;

-- INSERT INTO Employees
--   (Id, Name, Location)
-- VALUES
--   (1, N'Harret', N'Leigh'),
--   (12, N'John', N'Westcliff');

-- SET IDENTITY_INSERT to OFF.  
-- SET IDENTITY_INSERT Employees OFF;

-- query to select and display table Employees
SELECT *
FROM Employees;
