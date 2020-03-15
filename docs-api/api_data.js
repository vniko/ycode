define({ "api": [
  {
    "type": "post",
    "url": "/api/website",
    "title": "Create a New Website",
    "version": "0.0.1",
    "name": "create_website",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>Name of the Webiste</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "url",
            "description": "<p>URL of the Website</p>"
          }
        ]
      }
    },
    "group": "Website",
    "filename": "app/Http/Controllers/Api/WebsiteController.php",
    "groupTitle": "Website"
  },
  {
    "type": "get",
    "url": "/api/website",
    "title": "Get a list of websites",
    "version": "0.0.1",
    "name": "get_websites",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "filter",
            "description": "<p>Search Filter String</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "orderBy",
            "description": "<p>Order By Column Name</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "orderDir",
            "description": "<p>Order By Direction</p>"
          }
        ]
      }
    },
    "group": "Website",
    "success": {
      "examples": [
        {
          "title": "Success Response Example",
          "content": "{\n        \"data\": [\n        {\n            \"id\": 11,\n            \"name\": \"Baumbach-Crooks Website\",\n            \"url\": \"http://www.schumm.com/\"\n         },\n        {\n            \"id\": 21,\n            \"name\": \"Beahan-Kuhic Website\",\n            \"url\": \"https://weber.com/est-qui-reiciendis-vel-aut.html\"\n        },\n        ]\n     }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/WebsiteController.php",
    "groupTitle": "Website"
  }
] });
