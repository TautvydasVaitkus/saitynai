<h1><p align="center">Galutinė ataskaita</p></h1>

>Projekto tikslas - sukurti kompiuterinių žaidimų žaidimo debesyse platformą.


>Taikomosios sritios objektai: Šalis < Kompiuteris < Klientas


Platformoje bus talpinami kompiuteriai, esantys tam tikrose lokacijose, kuriuos klientai galės išsinuomoti ir per virtualią aplikaciją prisijungti prie įrenginio, bei jį naudoti žaidimams. Neužsiregistravę klientai galės matyti kokios lokacijos egzistuoja ir kokius įrenginius galima išsinuomoti kiekvienoje lokacijoje. Užsiregistravęs klientas galės užsisakyti norimą įrenginį.

## Funkciniai reikalavimai
*Neregistruoto sistemos naudotojo galimybės:*
1. Peržiūrėti pradinį puslapį
2. Užsiregistruoti platformoje
3. Peržiūrėti lokacijas, bei jose esančius įrenginius


*Registruoto sistemos naudotojo galimybes:*
1. Prisijungti prie platformos
2. Atsijungti nuo platformos
3. Redaguoti savo profilio informaciją
4. Išsinuomoti įrenginį



*Administratoriaus galimybės:*
1. Sukurti lokacijas
2. Sukurti įrenginius
3. Sukurti vartotojus
4. Redaguoti lokacijas
5. Redaguoti įrenginius
6. Redaguoti vartotojus
7. Pašalinti lokacijas
8. Pašalinti įrenginius
9. Pašalinti vartotojus



## Pasirinktos technologijos projekto įgyvendinimui
- Kliento pusė (angl. Front-end) - **React.js**
- Serverio pusė (angl. Back-end) - **PHP (Symfony framework)**
- Duomenų bazė - **MySQL**

&nbsp;
## API specifikacija
### Lokacijos tipas
```http
GET /api/v1/locations
```
Galimi atsako kodai: 
- 401 - Unauthorized
- 200 - OK

&nbsp;
```http
GET /api/v1/locations/{id}
```
Galimi atsako kodai: 
- 401 - Unauthorized
- 404 - Not Found
- 200 - OK

&nbsp;
```http
POST /api/v1/locations
```
Body:
```json
{
    "name": "Name of the location"
}
```
Galimi atsako kodai:
- 401 - Unauthorized
- 201 - Created

&nbsp;
```http
PUT /api/v1/locations/{id}
```
Body:
```json
{
    "name": "New name of the location"
}
```
Galimi atsako kodai: 
- 401 - Unauthorized
- 404 - Not Found
- 200 - OK

&nbsp;
```http
DELETE /api/v1/locations/{id}
```
Galimi atsako kodai:
- 401 - Unauthorized
- 404 - Not Found
- 204 - No Content

&nbsp;
## Kompiuteris
```http
GET /api/v1/locations/{id}/machines
```
Galimi atsako kodai: 
- 401 - Unauthorized
- 404 - Not Found
- 200 - OK

&nbsp;
```http
GET /api/v1/locations/{id}/machines/{id}
```
Galimi atsako kodai: 
- 401 - Unauthorized
- 404 - Not Found
- 200 - OK

&nbsp;
```http
POST /api/v1/locations/{id}/machines
```
Body:
```json
{
    "name": "Name of the machine",
    "cpu": "CPU name",
    "storage": "Amount of storage",
    "ram": "Amount of ram",
    "price": "Monthly price"
}
```
Galimi atsako kodai:
- 401 - Unauthorized
- 403 - Forbidden
- 404 - Not Found
- 201 - Created

&nbsp;
```http
PUT /api/v1/locations/{id}/machines/{id}
```
Body:
```json
{
    "name": "NEW Name of the machine",
    "cpu": "NEW CPU name",
    "storage": "NEW Amount of storage",
    "ram": "NEW Amount of ram",
    "price": "NEW Monthly price"
}
```
Galimi atsako kodai: 
- 401 - Unauthorized
- 403 - Forbidden
- 404 - Not Found
- 200 - OK

&nbsp;
```http
DELETE /api/v1/locations/{id}/machines/{id}
```
Galimi atsako kodai:
- 401 - Unauthorized
- 403 - Forbidden
- 404 - Not Found
- 204 - No Content

&nbsp;
## Klientas
```http
GET /api/v1/locations/{id}/machines/{id}/customers
```
Galimi atsako kodai: 
- 401 - Unauthorized
- 404 - Not Found
- 200 - OK

&nbsp;
```http
GET /api/v1/locations/{id}/machines/{id}/customers/{id}
```
Galimi atsako kodai: 
- 401 - Unauthorized
- 404 - Not Found
- 200 - OK

&nbsp;
```http
POST /api/v1/locations/{id}/machines/{id}/customers
```
Body:
```json
{
    "firstName": "FirstName",
    "lastName": "LastName",
    "email": "email@address.com"
}
```
Galimi atsako kodai:
- 401 - Unauthorized
- 403 - Forbidden
- 404 - Not Found
- 201 - Created

&nbsp;
```http
PUT /api/v1/locations/{id}/machines/{id}/customers/{id}
```
Body:
```json
{
    "firstName": "FirstName",
    "lastName": "LastName",
    "email": "email@address.com"
}
```
Galimi atsako kodai: 
- 401 - Unauthorized
- 403 - Forbidden
- 404 - Not Found
- 200 - OK

&nbsp;
```http
DELETE /api/v1/locations/{id}/machines/{id}/customers/{id}
```
Galimi atsako kodai:
- 401 - Unauthorized
- 403 - Forbidden
- 404 - Not Found
- 204 - No Content


## Autentifikacija
```http
POST /api/v1/login_check
```
Body: 
```json
{
    "email": "tautvydas97@gmail.com",
    "password": "admin"
}
```
Galimi atsako kodai:
- 400 - Bad Request
- 200 - OK