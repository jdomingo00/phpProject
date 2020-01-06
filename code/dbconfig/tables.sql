DROP DATABASE IF EXISTS gestionhospital;
CREATE DATABASE gestionhospital;
\c gestionhospital;

CREATE TABLE users (
	uname VARCHAR(20),
	password VARCHAR(20),
	fullName VARCHAR(50),
	signinDate DATE,
	lastLogin DATE,
	lastLogout DATE,
	type CHAR,
	PRIMARY KEY(uname)
);

CREATE TABLE departamentos(
	id SERIAL,
	nombre VARCHAR(30),
	PRIMARY KEY(id)
);
CREATE TABLE administradores (
	dni VARCHAR(10),
	horaInicio VARCHAR(10),
	horaFinal VARCHAR(10),
	PRIMARY KEY(dni)
)INHERITS (users);

CREATE TABLE medicos(
	numColegiado VARCHAR(10),
	departamento INT,
	PRIMARY KEY(numColegiado),
	FOREIGN KEY(departamento) REFERENCES departamentos (id)
)INHERITS (users);

CREATE TABLE horario(
	medico VARCHAR(10),
	dia VARCHAR(10),
	horaEntrada VARCHAR(10),
	horaSalida VARCHAR(10),
	PRIMARY KEY(medico, dia, horaEntrada, horaSalida),
	FOREIGN KEY(medico) REFERENCES medicos (numColegiado)
);

CREATE TABLE pacientes(
	dni VARCHAR(10),
	fecNacimiento DATE,
	mutua varchar(20),
	PRIMARY KEY(dni)
)INHERITS (users);

CREATE TABLE historialMedico (
	paciente VARCHAR(10),
	fecha DATE,
	hora VARCHAR(10),
	descripcion TEXT,
	PRIMARY KEY(paciente, fecha, hora),
	FOREIGN KEY(paciente) REFERENCES pacientes (dni)
);

CREATE TABLE horasAsignadas(
	fecha DATE,
	hora VARCHAR(10),
	medico VARCHAR(10),
	paciente VARCHAR(10),
	estado VARCHAR(10),
	PRIMARY KEY(fecha, hora, medico),
	FOREIGN KEY(medico) REFERENCES medicos(numColegiado),
	FOREIGN KEY(paciente) REFERENCES pacientes (dni)
);

INSERT INTO administradores VALUES ('admin1','1234','Administrador 1', '2020-01-01', '2020-01-01', '2020-01-01', 'a', '12345678A', '08:00', '13:00');
INSERT INTO departamentos (nombre) VALUES ('Cardiología');
INSERT INTO departamentos (nombre) VALUES ('Traumatología');
INSERT INTO departamentos (nombre) VALUES ('Pediatría');
INSERT INTO departamentos (nombre) VALUES ('Geriatría');
INSERT INTO departamentos (nombre) VALUES ('Nutriología');
INSERT INTO departamentos (nombre) VALUES ('Psiquiatría');
INSERT INTO departamentos (nombre) VALUES ('Neurología');
INSERT INTO departamentos (nombre) VALUES ('Medicina general');
INSERT INTO departamentos (nombre) VALUES ('Dermatología');

INSERT INTO medicos VALUES ('medico1', '1234', 'Medico 1', '2020-01-01', '2020-01-01', '2020-01-01', 'm', '123456789', 1);

INSERT INTO pacientes VALUES ('usuario1', '1234', 'Paciente 1', '2020-01-01', '2020-01-01', '2020-01-01', 'p', '98765432a', '2000-12-26', '54321');