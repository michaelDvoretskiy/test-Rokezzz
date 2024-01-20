Opis endpointow:

1. GET /work-application - lista wcześniej oglądanych aplikacji do pracy.

Opcje:
-orderBy (opcjonalne) - pole według którego sortowana jest otrzymana lista, dopuszczalne wartości ['firstName', 'lastName', 'position', 'level']
-orderDir (opcjonalne) - kierunek sortowania, dozwolone wartości ['asc', 'desc']
- userId (opcjonalne) - wartość liczbowa, identyfikator użytkownika

Jeśli zostanie przekazany identyfikator użytkownika, zostaną wyświetlone aplikacji do pracy, o których użytkownik przeglądał szczegółowe informacje (endpoint GET /work-application/{workAppId})
Jeżeli identyfikator użytkownika nie zostanie przekazany, wyświetlone zostaną aplikacji do pracy dodane wcześniej niż bieżąca data

Wartość zwracana: lista aplikacji do pracy. Przykład:
status: 200
[
     {
         "identyfikator": 2,
         "firstName": "Svitlana",
         "lastName": "Dvoretska",
         "pozycja": "tester manualny",
         "poziom": "junior"
     }
]

2. GET /work-application/new - lista niewyświetlonych ogłoszeń.

Opcje:
-orderBy (opcjonalne) - pole według którego sortowana jest otrzymana lista, dopuszczalne wartości ['firstName', 'lastName', 'position', 'level']
-orderDir (opcjonalne) - kierunek sortowania, dozwolone wartości ['asc', 'desc']
- userId (opcjonalne) - wartość liczbowa, identyfikator użytkownika

W przypadku przekazania identyfikatora użytkownika wyświetlane są aplikacji do pracy, o których użytkownik nie przeglądał szczegółowych informacji (endpoint GET /work-application/{workAppId})
Jeżeli identyfikator użytkownika nie zostanie przekazany, wyświetlone zostaną ogłoszenia dodane w bieżącej date

Wartość zwracana: lista aplikacji do pracy. Przykład:
status: 200
[
     {
         "identyfikator": 3,
         "firstName": "Mychajło",
         "lastName": "Dvoretskyi",
         "stanowisko": "programista PHP",
         "poziom": "regularny"
     }
]

3. GET /work-application/{workAppId} - szczegółowe dane o aplikacji do pracy o identyfikatorze workAppId

Opcje:
- userId (opcjonalne) - wartość liczbowa, identyfikator użytkownika

Jeśli zostanie przekazany identyfikator użytkownika, bieżąca aplikacja do pracy zostanie oznaczona jako przeglądana dla użytkownika userId

Wartość zwracana: zestaw atrybutów aplikacji do pracy. Przykład
status: 200
{
     "identyfikator": 2,
     "firstName": "Svitlana",
     "lastName": "Dvoretska",
     "e-mail": "svetag603@gmail.com",
     "telefon": "123456789",
     "wynagrodzenie": 4000,
     "pozycja": "tester manualny",
     "poziom": "junior",
     "dateCreated": "2024-01-19 09:34:31"
}

4. POST /work-application - dodanie nowego aplikacji do pracy
Body (przykład)
{
     "firstName": "Anna",
     "lastName": "Dvoretska",
     "e-mail": "anna@gmail.com",
     "telefon": "1234567689",
     "wynagrodzenie": 3500,
     "stanowisko": "PM"
}

Wartość zwracana (przykład):
status: 200
{
     "id": 7
}

5. PUT /work-application/{workAppId} - edycja aplikacji do pracy
Body (przykład)
{
     "firstName": "Anna",
     "lastName": "Dvoretska",
     "e-mail": "anna@gmail.com",
     "telefon": "1234567689",
     "wynagrodzenie": 4500,
     "stanowisko": "PM"
}

Wartość zwracana (przykład):
status: 200
{
     "success": true
}

5. DELETE /work-application/{workAppId} - usunięcie ogłoszenia

Wartość zwracana (przykład):
status: 200
{
     "success": true
}


Jeśli weryfikacja nie powiedzie się, dane zostaną zwrócone
status 422
Przykład
{
    "errors": [
        {
            "property": "firstName",
            "value": null,
            "message": "Parameter should be passed"
        },
        {
            "property": "lastName",
            "value": "",
            "message": "Should be at least 2 symbols"
        },
        {
            "property": "email",
            "value": "anna@g@mail.com",
            "message": "This field value should be a valid email"
        }
     ]
}

Jeśli wystąpi nieoczekiwany błąd, taki jak błąd bazy danych, zostaną zwrócone
status 400
{
     'message' => 'Somethoing went wrong'
}