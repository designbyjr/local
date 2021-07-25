## The task

Design and implement an API for an app that manages keys and their translations. In scope of the API you will need to work with multiple objects: keys, languages, translations & API tokens.
- Key. A key holds together translations for one translated phrase.
- Translation. A translation is a translated phrase for the key in a specific language.
- Language. A language implies that a translation can be added in this language.
- API token. A token that identifies the user and checks if the user has sufficient permissions to perform an action.

**Please read the acceptance criteria carefully.**

## Acceptance criteria

###  Language should:
- Have a name
- Have an ISO code
- Have Right To Left (RTL) flag
- Be generated using DB migration or any other similar method (5 languages will be enough, with at least 1 RTL language)

### Key should:
- Have a unique name
- Be identified by ID trough API (not name)
- Have one translation per language at all times

### Translation should:
- Have a value
- Have an associated key (referred using ID)
- Have an associated language (reffered using ISO code)

### API tokens should:
- Be stored in the database
- Be unique
- Be one of 2 types (read-only, read-write)
- Be generated using DB migration or any other similar method (1 read-only and 1 read-write will be enough)

### API should provide this functionality:
- API token authentication
- List available languages
- Manage keys
    - List
    - Retrieve
    - Create
    - Rename
    - Delete
- Manage translations
    - Update values in each language        
- Export translations in zip (separately for each format)
    - In .json format with 1 file per language ([language-iso].json)
        - format: {key.name: translation.value, ...}
    - In .yaml with all languages in 1 file (translations.yaml). All keys should be listed under specific language.
        - format & hierarchy: language.iso -> key.name -> translation.value 


## Notes

- You can use any PHP framework you are comfortable with
- Unit tests will be considered a bonus
- Dockerizing the app will be considered a bonus

## Demo of the API

### You have to demonstrate in an HTTP client of your choice:
- How the authorization works
- How languages are listed
- How keys are created, listed, renamed and deleted 
- How multiple keys with the same name cannot be created
- How translations are updated
- How export works for both formats

## Initial evaluation
To improve the speed of the inital evaluation, please provide request & response examples. If possible, provide examples with more details (comments) for better understanding.
```
GET /items

{
 "items": []
}

POST /items

{
 "name": "value"
}

{
 "response": "object"
}
```
