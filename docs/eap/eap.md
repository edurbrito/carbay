# EAP: Architecture Specification and Prototype

An online bidding platform destined for car model lovers, allowing them to sell or complete their private collections, by participating in real-time traditional auctions and interacting with other worldwide collectors.

## A7: High-level architecture. Privileges. Web resources specification

This artefact presents an overview of the web resources to implement, organized into modules. The permissions used in the modules to establish the conditions of access to resources are also included in this artefact.

This specification adheres to the OpenAPI standard using YAML.

### 1. Overview

| Module | Description |
| ---- | ---- |
| M01: Static pages | Web resources with static content are associated with this module: Home Page, About Us, and FAQ. |
| M02: Authentication | Web resources associated with user authentication includes: login/logout, registration, password recovery. |
| M03: Auctions | Web resources associated with auctions, includes: auctions list and search, viewing details and creating new auctions, comments and bids. |
| M04: Users | Web resources associated with user profile and individual profile management. It features auctions like view user profile, user bids, auctions created, favourite auctions, favourite sellers, users ratings, users rated and view and edit personal information. |
| M05: Help Messages | Web resources associated with help messages. It features actions like requesting admin help and listing all the help messages. |
| M06: Reports | Web resources associated with user reports. It features actions like reporting a given user. |
| M07: Administration | Web resources related to the website administration. It features actions like managing auctions and users, view and answer help messages, list and act on user reports. |

### 2. Permissions

| Type | Permission | Description |
| ---- | ---- | ---- |
| PUB |	Public | Users without privileges |
| USR |	User | Registered users |
| OWN |	Owner |	User that are owners of the information |
| ADM |	Administrator | Administrators |
| SEL | Seller | User that creates an auction | 
| BUY | Bidder | User that bids in an auction |

### 3. OpenAPI Specification

[OpenAPI YAML file](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/blob/master/docs/eap/a7_openapi.yaml)

[Swagger generated documentation](https://app.swaggerhub.com/apis/lbaw2155/lbaw2155-api/1.0)

```yaml
openapi: 3.0.0

info:
  version: '1.0'
  title: LBAW CarBay Web API
  description: Web Resources Specification (A7) for CarBay

servers:
- url: http://lbaw2155.lbaw-prod.fe.up.pt/
  description: Production server

externalDocs:
  description: Find more info here.
  url: https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap

tags:
  - name: 'M01: Static Pages'
  - name: 'M02: Authentication'
  - name: 'M03: Auctions'
  - name: 'M04: Users'
  - name: 'M05: Help Messages'
  - name: 'M06: Reports'
  - name: 'M07: Administration'

paths:

  /:
    get:
      operationId: R101
      summary: 'R101: View home page'
      description: 'Show homepage and featured auctions. Access: PUB'
      tags:
        - 'M01: Static Pages'

      responses:
        '200':
          description: 'Ok. Show [UI01](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/er#ui01-homepage)'
                             
  /about:
    get:
      operationId: R102
      summary: 'R102: About Us Page'
      description: 'Show About Us page. Access: PUB'
      tags:
        - 'M01: Static Pages'
      responses:
        '200':
          description: 'Ok. Show [UI02](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/er#ui02-about-us)'
          
  /faqs:
    get:
      operationId: R103
      summary: 'R103: FAQs Page'
      description: 'Show FAQs page. Access: PUB'
      tags:
        - 'M01: Static Pages'
      responses:
        '200':
          description: 'Ok. Show [UI03](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/er#ui03-faqs)' 

  /login:
    get:
      operationId: R201
      summary: 'R201: Login Form'
      description: 'Provide login form. Access: PUB'
      tags:
        - 'M02: Authentication'
      responses:
        '200':
          description: 'Ok. Show [UI05](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/er#ui05-log-in)'

    post:
      operationId: R202
      summary: 'R202: Login Action'
      description: 'Processes the login form submission. Access: PUB'
      tags:
        - 'M02: Authentication'
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                email:
                  type: string
                password:
                  type: string
              required:
                - email
                - password

      responses:
        '302':
          description: 'Redirect after processing the login credentials.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful authentication. Redirect to search page.'
                  value: '/auctions/search'
                302Failure:
                  description: 'Failed authentication. Redirect to login form.'
                  value: '/login'
                
  /logout:
    post:
        operationId: R203
        summary: 'R203: Logout Action'
        description: 'Logout the current authenticated user. Access: USR, ADM'
        tags:
          - 'M02: Authentication'
        responses:
          '302':
            description: 'Redirect after processing logout.'
            headers:
              Location:
                schema:
                  type: string
                examples:
                  302Success:
                    description: 'Successful logout. Redirect to login form.'
                    value: '/homepage'
                    
  /signup:
    get:
      operationId: R204
      summary: 'R204: Signup Form'
      description: 'Provide new user signup form. Access: PUB'
      tags:
        - 'M02: Authentication'
      responses:
        '200':
          description: 'Ok. Show [UI06](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/er#ui06-sign-up)'

    post:
      operationId: R205
      summary: 'R205: Signup Action'
      description: 'Processes the new user signup form submission. Access: PUB'
      tags:
        - 'M02: Authentication'

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                name:
                  type: string
                username:
                  type: string
                email:
                  type: string
                password:
                  type: string
              required:
                - username
                - name
                - email
                - password

      responses:
        '302':
          description: 'Redirect after processing the new user information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful authentication. Redirect to search page.'
                  value: '/auctions/search'
                302Failure:
                  description: 'Failed authentication. Redirect to signup form.'
                  value: '/signup'

  /auctions/search: 
    get:
      operationId: R301
      summary: 'R301: View search page'
      description: 'Show the search page with all the auctions. Access: PUB'
      tags:
        - 'M03: Auctions'
     
      responses:
        '200':
          description: 'Ok. Show [UI07](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/er#ui07-search)'

  /auctions/{id}:
    get:
      operationId: R302
      summary: 'R302: View auction page'
      description: 'Show the auction details. If the user is SEL, also show the bid authors, and the bid and buy now options are not available. If the user is ADM, these options are also not available, and besides seeing the bid authors, an extra scheduling/cancelling option is shown. Access: PUB'
      tags:
        - 'M03: Auctions'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      responses:
        '200':
          description: 'Ok. Show [UI08](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/er#ui08-auction-page-chat)'
          
  /auctions/{id}/bids:
    get:
      operationId: R303
      summary: 'R303: View auction bid history'
      description: 'View all bids made in the auction. If the user is SEL or ADM, also show the bid authors. Access: PUB'
      tags:
        - 'M03: Auctions'
    
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
            
      responses:
        '200':
          description: 'Ok. Show [UI09](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/er#ui09-auction-page-bid-history)'
      
    post:
      operationId: R304
      summary: 'R304: Bid in auction'
      description: 'Processes the new bid in the auction. Access: BUY'
      tags:
        - 'M03: Auctions'
    
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                value:
                  type: number
              required:
                - value

      responses:
        '302':
          description: 'Redirect after processing the new bid information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful bid. Redirect to auction page.'
                  value: '/auctions/{id}'
                302Failure:
                  description: 'Failed bid. Redirect to auction page.'
                  value: '/auctions/{id}'

  /auctions/{id}/comments:
    get:
      operationId: R305
      summary: 'R305: View all comments in auction'
      description: 'View all comments made in the auction chat. Access: PUB'
      tags:
        - 'M03: Auctions'
    
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
          
      responses:
        '200':
          description: 'Ok. Show [UI08](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/er#ui08-auction-page-chat)'
      
    post:
      operationId: R306
      summary: 'R306: Comment in auction'
      description: 'Processes the new comment in the auction. Access: USR'
      tags:
        - 'M03: Auctions'
    
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                text:
                  type: string
              required:
                - text
                
      responses:
        '302':
          description: 'Redirect after processing the new comment.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful comment. Redirect to auction page.'
                  value: '/auctions/{id}'
                302Failure:
                  description: 'Failed comment. Redirect to auction page.'
                  value: '/auctions/{id}'

  /auctions/{id}/buy_now:   
    post:
      operationId: R307
      summary: 'R307: Buy Now in the auction'
      description: 'Processes the use of the Buy Now option in the auction. Access: BUY'
      tags:
        - 'M03: Auctions'
    
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                value:
                  type: number
              required:
                - value

      responses:
        '302':
          description: 'Redirect after processing buy now action.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful buy now. Redirect to auction page.'
                  value: '/auctions/{id}'
                302Failure:
                  description: 'Failed buy now. Redirect to auction page.'
                  value: '/auctions/{id}'
          
  /auctions/{id}/rate:
    post:                    
      operationId: R308
      summary: 'R308: Submit rating'
      description: 'Rate a given auction. Access: BUY'
      tags:
        - 'M03: Auctions'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                rating:
                  type: integer
                text:
                  type: string
              required:
                - rating

      responses:
        '302':
          description: 'Redirect after processing rating to auction.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful rating to auction request. Redirect to auction page.'
                  value: '/auctions/{auction}'
                302Failure:
                  description: 'Failed rating to auction request. Redirect to auction page.'
                  value: '/auctions/{auction}'       
  
  /auctions/create:
    get:
      operationId: R309
      summary: 'R309: Create new auction'
      description: 'Provide new auction information form. Access: SEL'
      tags:
        - 'M03: Auctions'
      responses:
        '200':
          description: 'Ok. Show [UI10](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/er#ui10-create-auction-general-info)'

    post:
      operationId: R310
      summary: 'R310: Create new auction Action'
      description: 'Processes the new auction information form submission. Access: SEL'
      tags:
        - 'M03: Auctions'

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                title:
                  type: string
                starting_bid:
                  type: number
                start_date:
                  type: string
                buy_now:
                  type: number
                duration:
                  type: integer
                color:
                  type: string
                brand:
                  type: string
                scale:
                  type: string
                photos: 
                  type: array
                  items:
                    type: string
                description:
                  type: string
              required:
                - title
                - starting_bid
                - start_date
                - duration
                - color
                - brand
                - scale
                - photos
                - description
      responses:
        '302':
          description: 'Redirect after processing the new auction information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful creation. Redirect to auction page.'
                  value: '/auctions/{id}'
                302Failure:
                  description: 'Failed auction creation. Redirect to create auction page.'
                  value: '/auctions/create'
                  
  /auctions/{id}/manage:
    put:
      operationId: R701
      summary: 'R701: Reschedule/Suspend the auction'
      description: 'Processes the admin action in the auction. Access: ADM'
      tags:
        - 'M07: Administration'
    
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                suspend:
                  type: boolean
                start_date:
                  type: string
                final_date:
                  type: string
      responses:
        '302':
          description: 'Redirect after processing auction management.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful auction management request. Redirect to auction page.'
                  value: '/auctions/{id}'
                302Failure:
                  description: 'Failed auction management request. Redirect to auction page.'
                  value: '/auctions/{id}'
                    
  /users/{username}:
    get:
      operationId: R401
      summary: 'R401: View user profile'
      description: 'Show the individual user profile. If the user is OWN, also show the personal statistics, bid history and favourite lists. If user is ADM, besides all the user private information, also show a ban option. Access: PUB'
      tags:
        - 'M04: Users'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Ok. Show [UI12](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/er#ui12-profile)'
            
  /users/{username}/edit:
    get:
      operationId: R402
      summary: 'R402: Edit user profile'
      description: 'Edit the user profile information. Access: OWN'
      tags:
        - 'M04: Users'
        
      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true
          
      responses:
        '200':
          description: 'Ok. Show [UI13](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/er#ui13-edit-profile)'

    put:
      operationId: R403
      summary: 'R403: Edit Profile Action'
      description: 'Processes the new user profile form submission. Access: OWN'
      tags:
        - 'M04: Users'
    
      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                name:
                  type: string
                email:
                  type: string
                old_password:
                  type: string
                new_password:
                  type: string
                photo:
                  type: string
              required:
                - old_password
      responses:
        '302':
          description: 'Redirect after processing the updated user information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful update. Redirect to profile page.'
                  value: '/users/{username}'
                302Failure:
                  description: 'Failed update. Redirect to edit profile form.'
                  value: '/users/edit'

  /users/{username}/bids:
    get:
      operationId: R404
      summary: 'R404: User bid history'
      description: 'List all the bids created by the user. Access: OWN, ADM'
      tags:
        - 'M04: Users'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Ok. Show [UI14](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/er#ui14-profile-bid-history)'

  /users/{username}/auctions:
    get:
      operationId: R405
      summary: 'R405: Auctions created by the user'
      description: 'List all the auctions created by the user. Access: PUB'
      tags:
        - 'M04: Users'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Ok. Show [UI15](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/er#ui15-profile-auctions-created)'

  /users/{username}/fav_auctions:
    get:
      operationId: R406
      summary: 'R406: User favourite auctions'
      description: 'List all the favourite auctions of the user. Access: OWN'
      tags:
        - 'M04: Users'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Ok. Show [UI16](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/er#ui16-profile-favourite-auctions)'

  /users/{username}/fav_auctions/add:
    post:                    
      operationId: R407
      summary: 'R407: Add favourite auction'
      description: 'Add auction to favourite list. Access: OWN'
      tags:
        - 'M04: Users'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                id:
                  type: integer
              required:
                - id
      responses:
        '302':
          description: 'Redirect after processing favourite auction.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful add favourite auction request. Redirect to auction page.'
                  value: '/auctions/{id}'
                302Failure:
                  description: 'Failed add favourite auction request. Redirect to auction page.'
                  value: '/auctions/{id}'    

  /users/{username}/fav_auctions/remove:
    post:                    
      operationId: R408
      summary: 'R408: Remove favourite auction'
      description: 'Remove auction from favourite list. Access: OWN'
      tags:
        - 'M04: Users'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                id:
                  type: integer
              required:
                - id
      responses:
        '302':
          description: 'Redirect after processing favourite auction.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful remove favourite auction request. Redirect to auction page.'
                  value: '/auctions/{id}'
                302Failure:
                  description: 'Failed remove favourite auction request. Redirect to auction page.'
                  value: '/auctions/{id}'    

  /users/{username}/fav_sellers:
    get:
      operationId: R409
      summary: 'R409: User favourite sellers'
      description: 'List all the favourite sellers of the user. Access: OWN'
      tags:
        - 'M04: Users'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Ok. Show [UI17](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/er#ui17-profile-favourite-sellers)'

  /users/{username}/fav_sellers/add:
    post:                    
      operationId: R410
      summary: 'R410: Add favourite seller'
      description: 'Add seller to favourite list. Access: OWN'
      tags:
        - 'M04: Users'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                seller:
                  type: string
              required:
                - seller

      responses:
        '302':
          description: 'Redirect after processing favourite seller.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful add favourite seller request. Redirect to profile page.'
                  value: '/users/{seller}'
                302Failure:
                  description: 'Failed add favourite seller request. Redirect to profile page.'
                  value: '/users/{seller}'   
                 
  /users/{username}/fav_sellers/remove:
    post:                    
      operationId: R411
      summary: 'R411: Remove favourite seller'
      description: 'Remove seller from favourite list. Access: OWN'
      tags:
        - 'M04: Users'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                seller:
                  type: string
              required:
                - seller

      responses:
        '302':
          description: 'Redirect after processing favourite seller.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful remove favourite seller request. Redirect to profile page.'
                  value: '/users/{seller}'
                302Failure:
                  description: 'Failed remove favourite seller request. Redirect to profile page.'
                  value: '/users/{seller}' 
  
  /users/{username}/ratings:
    get:
      operationId: R412
      summary: 'R412: Ratings given to the user'
      description: 'List all the ratings given to the user. Access: PUB'
      tags:
        - 'M04: Users'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Ok. Show [UI18](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/er#ui18-profile-users-ratings)'

  /users/{username}/rated:
    get:
      operationId: R413
      summary: 'R413: Ratings given by the user'
      description: 'List all the ratings given by the user. Access: PUB'
      tags:
        - 'M04: Users'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Ok. Show [UI19](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/er#ui19-profile-users-rated)'

  /users/{username}/help:
    get:
      operationId: R501
      summary: 'R501: View Help Messages'
      description: 'View the Help Message chat. Access: OWN, ADM'
      tags:
        - 'M05: Help Messages'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Ok. Show [UI04](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/er#ui04-help)'

    post:                    
      operationId: R502
      summary: 'R502: Send Help Message'
      description: 'Send a new Help Message in the Help chat. Access: OWN'
      tags:
        - 'M05: Help Messages'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                text:
                  type: string
              required:
                - text

      responses:
        '302':
          description: 'Redirect after processing help message.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful help message request. Redirect to help page.'
                  value: '/users/{username}/help'
                302Failure:
                  description: 'Failed help message request. Redirect to help page.'
                  value: '/users/{username}/help'    

  /users/{username}/report:
    post:                    
      operationId: R601
      summary: 'R601: Submit a Report'
      description: 'Submit a Report to be reviewed by the administrators. Access: USR'
      tags:
        - 'M06: Reports'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                context:
                  type: string
                text:
                  type: string
              required:
                - context
                - text

      responses:
        '200':
          description: 'OK, after processing the report.'
                  
  /users/{username}/manage:
    put:
      operationId: R702
      summary: 'R702: Suspend the user'
      description: 'Processes the admin action in the user. Access: ADM'
      tags:
        - 'M07: Administration'
    
      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                suspend:
                  type: boolean

      responses:
        '302':
          description: 'Redirect after processing user management.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful user management request. Redirect to user profile.'
                  value: '/users/{username}'
                302Failure:
                  description: 'Failed user management request. Redirect to user profile.'
                  value: '/users/{username}'

  /admin/{username}/users:
    get:
      operationId: R703
      summary: 'R703: View Users Admin Panel'
      description: 'View Users Admin Panel. Access: ADM'
      tags:
        - 'M07: Administration'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Ok. Show [UI20](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/er#ui20-admin-panel-users-management)'

  /admin/{username}/auctions:
    get:
      operationId: R704
      summary: 'R704: View Auctions Admin Panel'
      description: 'View Auctions Admin Panel. Access: ADM'
      tags:
        - 'M07: Administration'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Ok. Show [UI21](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/er#ui21-admin-panel-auctions-management)'

  /admin/{username}/help:
    get:
      operationId: R705
      summary: 'R705: View Pending Help Messages'
      description: 'View Pending Help Messages from users. Access: ADM'
      tags:
        - 'M07: Administration'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Ok. Show [UI23](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/er#ui23-admin-panel-help)'

    post:                    
      operationId: R503
      summary: 'R503: Send Help Message'
      description: 'Send a new Help Message in the Help chat. Access: ADM'
      tags:
        - 'M05: Help Messages'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                recipient: 
                  type: string
                text:
                  type: string
              required:
                - recipient
                - text

      responses:
        '302':
          description: 'Redirect after processing help message.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful help message request. Redirect to help page.'
                  value: '/admin/{username}/help'
                302Failure:
                  description: 'Failed help message request. Redirect to help page.'
                  value: '/admin/{username}/help'    

  /admin/{username}/reports:
    get:
      operationId: R706
      summary: 'R706: View Pending Reports'
      description: 'View Pending Reports from users. Access: ADM'
      tags:
        - 'M07: Administration'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Ok. Show [UI22](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/er#ui22-admin-panel-reports)'
          
##################################################################################################################################

  /api/auctions/featured:
    get:
      operationId: R311
      summary: 'R311: Get all featured auctions'
      description: 'Search through all the featured auctions shown in the homepage. Access: PUB'
      tags:
        - 'M03: Auctions'
          
      responses:
        '200':
          description: 'Ok. Show featured auctions'
          content:
            application/json:
              schema:
                type: array
                items:
                  type: object
                  properties:
                    id:
                      type: integer
                    title:
                      type: string
                    final_date:
                      type: string
                    highest_bid:
                      type: number
                    buy_now:
                      type: number
                example:
                  - id: 1
                    title: 'Ferrari Portofino'
                    final_date: '2021-04-25 12:00:00'
                    highest_bid: 500
                    buy_now: 2000
                  - id: 4
                    title: 'Bentley Continental'
                    final_date: '2021-04-26 14:50:00'
                    highest_bid: 650
                    buy_now: 1950

  /api/auctions/search:
    get:
      operationId: R312
      summary: 'R312: Get search results'
      description: 'Search through all the auctions. Access: PUB'
      tags:
        - 'M03: Auctions'

      parameters:
        - in: query
          name: query
          description: 'String to use for full-text search'
          schema:
            type: string
          required: false
        - in: query
          name: sort_by
          description: 'Sort by Time Remaining, Last Bid, or Buy Now'
          schema:
            type: string
          required: false
        - in: query
          name: buy_now
          description: 'Boolean to search only auctions with buy now option'
          schema:
            type: boolean
          required: false
        - in: query
          name: ended_auctions
          description: 'Boolean to only show ended auctions'
          schema:
            type: boolean
          required: false
        - in: query
          name: color
          description: 'Filter by color name'
          schema:
            type: string
          required: false
        - in: query
          name: brand
          description: 'Filter by brand name'
          schema:
            type: string
          required: false
        - in: query
          name: scale
          description: 'Filter by scale of the model'
          schema:
            type: string
          required: false
        - in: query
          name: seller
          description: 'Filter by seller name'
          schema:
            type: string
          required: false
        - in: query
          name: min_bid
          description: 'Only show auctions with last bids whose value is above the minimum'
          schema:
            type: number
          required: false
        - in: query
          name: max_bid
          description: 'Only show auctions with last bids whose value is below the maximum'
          schema:
            type: number
          required: false
        - in: query
          name: min_buy_now
          description: 'Only show auctions with buy now value above the minimum'
          schema:
            type: number
          required: false
        - in: query
          name: max_buy_now
          description: 'Only show auctions with buy now value below the maximum'
          schema:
            type: number
          required: false
          
      responses:
        '200':
          description: 'Ok. Show auctions'
          content:
            application/json:
              schema:
                type: array
                items:
                  type: object
                  properties:
                    id:
                      type: integer
                    image_url:
                      type: string
                    title:
                      type: string
                    final_date:
                      type: string
                    highest_bid:
                      type: number
                    buy_now:
                      type: number
                    seller:
                      type: string
                    seller_rating:
                      type: number
                example:
                  - id: 1
                    image_url: 'https://lbaw2155-piu/static/images/qkewndms-qqnw-213-skmsmsak.jpg'
                    title: 'Ferrari Portofino'
                    final_date: '2021-04-25 12:00:00'
                    highest_bid: 500
                    buy_now: 2000
                    seller: 'johndoe'
                    seller_rating: 4.8
                  - id: 4
                    image_url: 'https://lbaw2155-piu/static/images/otituvnc-qoqo-345-mekwkwkw.jpg'
                    title: 'Bentley Continental'
                    final_date: '2021-04-26 14:50:00'
                    highest_bid: 650
                    buy_now: 1950
                    seller: 'rickwheels'
                    seller_rating: 4.2
                
  /api/auctions/{id}:
    get:
      operationId: R313
      summary: 'R313: View auction details'
      description: 'Show the auction details. Access: PUB'
      tags:
        - 'M03: Auctions'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      responses:
        '200':
          description: 'Ok. Show auction details'
          content:
            application/json:
              schema:
                type: array
                items:
                  type: object
                  properties:
                    title:
                      type: string
                    seller:
                      type: string
                    colour:
                      type: string
                    brand:
                      type: string
                    scale:
                      type: string
                    description:
                      type: string
                    final_date:
                      type: string
                    highest_bid:
                      type: number
                    buy_now:
                      type: number
                example:
                  - title: "Ferrari Portofino"
                    seller: "johndoe"
                    colour: "Yellow"
                    brand: "Ferrari"
                    scale: "18:1"
                    description: "lorem ipsum description dusty rusty busty"
                    final_date: "2021-04-23 12:39:41"
                    highest_bid: 1345.12
                    buy_now: 2000
          
  /api/auctions/{id}/bids:
    get:
      operationId: R314
      summary: 'R314: View auction bid history'
      description: 'View all bids made in the auction. Access: PUB'
      tags:
        - 'M03: Auctions'
    
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
            
      responses:
        '200':
          description: 'Ok. Show auction bid history'
          content:
            application/json:
              schema:
                type: array
                items:
                  type: object
                  properties:
                    date:
                      type: string
                    value:
                      type: number
                example:
                  - date: "2021-04-23 12:39:41"
                    value: 1345.12
                  - date: "2021-04-23 12:39:55"
                    value: 1369.12
       
    post:
      operationId: R315
      summary: 'R315: Bid in auction'
      description: 'Processes the new bid in the auction. Access: BUY'
      tags:
        - 'M03: Auctions'
    
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                value:
                  type: number
              required:
                - value

      responses:
        '200':
          description: 'OK, after processing the new bid.'
          content:
            application/json:
              schema:
                type: object
                properties:
                  result:
                    type: string
                example:
                  - result: 'success'
     
  /api/auctions/{id}/comments:
    get:
      operationId: R316
      summary: 'R316: View all comments in auction'
      description: 'View all comments made in the auction chat. Access: PUB'
      tags:
        - 'M03: Auctions'
    
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
          
      responses:
        '200':
          description: 'Ok. Show all comments'
          content:
            application/json:
              schema:
                type: array
                items:
                  type: object
                  properties:
                    username:
                      type: string
                    text:
                      type: string
                    date:
                      type: string
                example:
                  - username: 'johndoe'
                    text: 'Bulish'
                    date: '2021-04-12 12:39:41'
                  - username: 'sophydoors'
                    text: 'Not Interest anymore in this piece of rubish'
                    date: '2021-04-12 12:39:41'

    post:
      operationId: R317
      summary: 'R317: Comment in auction'
      description: 'Processes the new comment in the auction. Access: USR'
      tags:
        - 'M03: Auctions'
    
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                text:
                  type: string
              required:
                - text
                
      responses:
        '200':
          description: 'OK, after processing the new comment.'
          content:
            application/json:
              schema:
                type: object
                properties:
                  result:
                    type: string
                example:
                  - result: 'success'

  /api/auctions/{id}/buy_now:   
    post:
      operationId: R318
      summary: 'R318: Buy Now in the auction'
      description: 'Processes the use of the Buy Now option in the auction. Access: BUY'
      tags:
        - 'M03: Auctions'
    
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                value:
                  type: number
              required:
                - value

      responses:
        '200':
          description: 'OK, after processing the buy now option.'
          content:
            application/json:
              schema:
                type: object
                properties:
                  result:
                    type: string
                example:
                  - result: 'success'

  /api/auctions/{id}/rate:
    post:                    
      operationId: R319
      summary: 'R319: Submit rating'
      description: 'Rate a given auction. Access: BUY'
      tags:
        - 'M03: Auctions'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                rating:
                  type: integer
                text:
                  type: string
              required:
                - rating

      responses:
        '200':
          description: 'OK, after processing the rating.'
          content:
            application/json:
              schema:
                type: object
                properties:
                  result:
                    type: string
                example:
                  - result: 'success'
 
  /api/auctions/create:
    post:
      operationId: R320
      summary: 'R320: Create new auction Action'
      description: 'Processes the new auction information. Access: SEL'
      tags:
        - 'M03: Auctions'

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                title:
                  type: string
                starting_bid:
                  type: number
                start_date:
                  type: string
                buy_now:
                  type: number
                duration:
                  type: integer
                color:
                  type: string
                brand:
                  type: string
                scale:
                  type: string
                photos: 
                  type: array
                  items:
                    type: string
                description:
                  type: string
              required:
                - title
                - starting_bid
                - start_date
                - duration
                - color
                - brand
                - scale
                - photos
                - description

      responses:
        '200':
          description: 'OK, after processing the auction creation.'
          content:
            application/json:
              schema:
                type: object
                properties:
                  result:
                    type: string
                example:
                  - result: 'success'

  /api/auctions/{id}/manage:
    put:
      operationId: R707
      summary: 'R707: Reschedule/Suspend the auction'
      description: 'Processes the admin action in the auction. Access: ADM'
      tags:
        - 'M07: Administration'
    
      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                suspend:
                  type: boolean
                start_date:
                  type: string
                final_date:
                  type: string

      responses:
        '200':
          description: 'OK, after processing the auction management.'
          content:
            application/json:
              schema:
                type: object
                properties:
                  result:
                    type: string
                example:
                  - result: 'success'

  /api/colours:
   get:
      operationId: R321
      summary: 'R321: Available Colours'
      description: 'View all available colour values. Access: PUB'
      tags:
        - 'M03: Auctions'

      responses:
        '200':
          description: 'Ok. Show all colour values'
          content:
            application/json:
              schema:
                type: array
                items:
                  type: object
                  properties:
                    colour:
                      type: string
                example:
                  - colour: 'Yellow'
                  - colour: 'Red'

  /api/brands:
   get:
      operationId: R322
      summary: 'R322: Available Brands'
      description: 'View all available brand values. Access: PUB'
      tags:
        - 'M03: Auctions'

      responses:
        '200':
          description: 'Ok. Show all brand values'
          content:
            application/json:
              schema:
                type: array
                items:
                  type: object
                  properties:
                    brand:
                      type: string
                example:
                  - brand: 'Ferrari'
                  - brand: 'Toyota'

  /api/scales:
   get:
      operationId: R323
      summary: 'R323: Available Scales'
      description: 'View all available scale values. Access: PUB'
      tags:
        - 'M03: Auctions'

      responses:
        '200':
          description: 'Ok. Show all scale values'
          content:
            application/json:
              schema:
                type: array
                items:
                  type: object
                  properties:
                    scale:
                      type: string
                example:
                  - scale: '18:1'
                  - scale: '24:1'

  /api/users/{username}:
    get:
      operationId: R414
      summary: 'R414: View user profile'
      description: 'Show the individual user profile. If the user is OWN, also show the personal statistics, bid history and favourite lists. If user is ADM, besides all the user private information, also show a ban option. Access: PUB'
      tags:
        - 'M04: Users'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Ok. Show user profile information'
          content:
            application/json:
              schema:
                type: object
                properties:
                  username:
                    type: string
                  name:
                    type: string
                  email:
                    type: string
                  rating:
                    type: number

  /api/users/{username}/edit:
    put:
      operationId: R415
      summary: 'R415: Edit Profile Action'
      description: 'Processes the new user profile form submission. Access: OWN'
      tags:
        - 'M04: Users'
    
      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                name:
                  type: string
                email:
                  type: string
                old_password:
                  type: string
                new_password:
                  type: string
                photo:
                  type: string
              required:
                - old_password
      responses:
        '200':
          description: 'OK, after processing the profile edit.'
          content:
            application/json:
              schema:
                type: object
                properties:
                  result:
                    type: string
                example:
                  - result: 'success'
  
  /api/users/{username}/bids:
    get:
      operationId: R416
      summary: 'R416: User bid history'
      description: 'List all the bids created by the user. Access: OWN, ADM'
      tags:
        - 'M04: Users'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Ok. Show Bids'
          content:
            application/json:
              schema:
                type: array
                items:
                  type: object
                  properties:
                    auction_id:
                      type: number
                    value:
                      type: number

  /api/users/{username}/auctions:
    get:
      operationId: R417
      summary: 'R417: Auctions created by the user'
      description: 'List all the auctions created by the user. Access: PUB'
      tags:
        - 'M04: Users'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Ok. Show Auctions'
          content:
            application/json:
              schema:
                type: array
                items:
                  type: object
                  properties:
                    id:
                      type: string
                    title:
                      type: string

  /api/users/{username}/fav_auctions:
    get:
      operationId: R418
      summary: 'R418: User favourite auctions'
      description: 'List all the favourite auctions of the user. Access: OWN'
      tags:
        - 'M04: Users'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Ok. Show favourite auctions'
          content:
            application/json:
              schema:
                type: array
                items:
                  type: object
                  properties:
                    id:
                      type: integer
                    title:
                      type: string
                    photo:
                      type: string
                example:
                  - id: 1
                    title: 'Ferrari Portofino'
                    photo: 'https://lbaw2155-piu/static/images/qkewndms-qqnw-213-skmsmsak.jpg'
                  - id: 4
                    title: 'Bentley Continental'
                    photo: 'https://lbaw2155-piu/static/images/otituvnc-qoqo-345-mekwkwkw.jpg'

  /api/users/{username}/fav_auctions/add:
    post:                    
      operationId: R419
      summary: 'R419: Add favourite auction'
      description: 'Add auction to favourite list. Access: OWN'
      tags:
        - 'M04: Users'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                id:
                  type: integer
              required:
                - id

      responses:
        '200':
          description: 'OK, after processing the add to favourite action.'
          content:
            application/json:
              schema:
                type: object
                properties:
                  result:
                    type: string
                example:
                  - result: 'success'

  /api/users/{username}/fav_auctions/remove:
    post:                    
      operationId: R420
      summary: 'R420: Remove favourite auction'
      description: 'Remove auction from favourite list. Access: OWN'
      tags:
        - 'M04: Users'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                id:
                  type: integer
              required:
                - id

      responses:
        '200':
          description: 'OK, after processing the remove from favourite action.'
          content:
            application/json:
              schema:
                type: object
                properties:
                  result:
                    type: string
                example:
                  - result: 'success'

  /api/users/{username}/fav_sellers:
    get:
      operationId: R421
      summary: 'R421: User favourite sellers'
      description: 'List all the favourite sellers of the user. Access: OWN'
      tags:
        - 'M04: Users'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Ok. Show favourite sellers'
          content:
            application/json:
              schema:
                type: array
                items:
                  type: object
                  properties:
                    username:
                      type: string
                    photo:
                      type: string
                example:
                  - username: 'johndoe'
                    photo: 'https://lbaw2155-piu/static/images/mdkjeam-skfjhejs.jpg'
                  - username: 'rickwheels'
                    photo: 'https://lbaw2155-piu/static/images/okqiela-grsusnre.jpg'
                    
  /api/users/{username}/fav_sellers/add:
    post:                    
      operationId: R422
      summary: 'R422: Add favourite seller'
      description: 'Add seller to favourite list. Access: OWN'
      tags:
        - 'M04: Users'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                seller:
                  type: string
              required:
                - seller

      responses:
        '200':
          description: 'OK, after processing the add to favourite action.'
          content:
            application/json:
              schema:
                type: object
                properties:
                  result:
                    type: string
                example:
                  - result: 'success'

  /api/users/{username}/fav_sellers/remove:
    post:                    
      operationId: R423
      summary: 'R423: Remove favourite seller'
      description: 'Remove seller from favourite list. Access: OWN'
      tags:
        - 'M04: Users'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                seller:
                  type: string
              required:
                - seller

      responses:
        '200':
          description: 'OK, after processing the remove from favourite action.'
          content:
            application/json:
              schema:
                type: object
                properties:
                  result:
                    type: string
                example:
                  - result: 'success' 
         
  /api/users/{username}/ratings:
    get:
      operationId: R424
      summary: 'R424: Ratings given to the user'
      description: 'List all the ratings given to the user. Access: PUB'
      tags:
        - 'M04: Users'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Ok. Show Ratings'
          content:
            application/json:
              schema:
                  type: array
                  items:
                    type: object
                    properties:
                      username:
                        type: string
                      description:
                        type: string
                      value:
                        type: number

  /api/users/{username}/rated:
    get:
      operationId: R425
      summary: 'R425: Ratings given by the user'
      description: 'List all the ratings given by the user. Access: PUB'
      tags:
        - 'M04: Users'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Ok. Show Ratings'
          content:
            application/json:
              schema:
                  type: array
                  items:
                    type: object
                    properties:
                      username:
                        type: string
                      description:
                        type: string
                      value:
                        type: number
           
  /api/users/{username}/notifications:
    get:
      operationId: R426
      summary: 'R426: View Pending Notifications'
      description: 'View the Pending Notifications list. Access: OWN'
      tags:
        - 'M04: Users'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Ok. Show Pending Notifications'
          content:
            application/json:
              schema:
                type: array
                items:
                  type: object
                  properties:
                    text:
                      type: string
                    date:
                      type: string
                example:
                  - text: "johndoe created a new auction! Go check it out"
                    date: "2021-04-23 12:39:41"
                  - text: "Auction #314 is over! View the results"
                    date: "2021-04-23 12:59:24"

  /api/users/{username}/help:
    get:
      operationId: R504
      summary: 'R504: View Help Messages'
      description: 'View the Help Messages list. Access: OWN, ADM'
      tags:
        - 'M05: Help Messages'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Ok. Show Help Messages'
          content:
            application/json:
              schema:
                type: array
                items:
                  type: object
                  properties:
                    sender:
                      type: string
                    text:
                      type: string
                    date:
                      type: string
                example:
                  - sender: 'johndoe'
                    text: "Will I be notified about my favourite seller?"
                    date: "2021-04-23 12:39:41"
                  - sender: 'rickwheels'
                    text: "Yes, you should be notified everytime a favourite seller of yours creates a new auction."
                    date: "2021-04-23 12:59:24"

    post:                    
      operationId: R505
      summary: 'R505: Send Help Message'
      description: 'Send a new Help Message. Access: OWN'
      tags:
        - 'M05: Help Messages'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                username:
                  type: string
                text:
                  type: string
              required:
                - username
                - text

      responses:
        '200':
          description: 'OK, after processing the help message.'
          content:
            application/json:
              schema:
                type: object
                properties:
                  result:
                    type: string
                example:
                  - result: 'success' 

  /api/users/{username}/report:
    post:                    
      operationId: R602
      summary: 'R602: Submit a Report'
      description: 'Submit a Report to be reviewed by the administrators. Access: USR'
      tags:
        - 'M06: Reports'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                context:
                  type: string
                text:
                  type: string
              required:
                - context
                - text

      responses:
        '200':
          description: 'OK, after processing the report.'
          content:
            application/json:
              schema:
                type: object
                properties:
                  result:
                    type: string
                example:
                  - result: 'success' 
                  
  /api/users/{username}/manage:
    put:
      operationId: R708
      summary: 'R708: Suspend the user'
      description: 'Processes the admin action in the user. Access: ADM'
      tags:
        - 'M07: Administration'
    
      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                suspend:
                  type: boolean

      responses:
        '200':
          description: 'OK, after processing the user management.'
          content:
            application/json:
              schema:
                type: object
                properties:
                  result:
                    type: string
                example:
                  - result: 'success'

  /api/admin/{username}/help:
    get:
      operationId: R709
      summary: 'R709: View Pending Help Messages'
      description: 'View Pending Help Messages from users. Access: ADM'
      tags:
        - 'M07: Administration'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Ok. Show Help Messages'
          content:
            application/json:
              schema:
                type: array
                items:
                  type: object
                  properties:
                    sender:
                      type: string
                    text:
                      type: string
                    date:
                      type: string
                example:
                  - sender: 'johndoe'
                    text: "Will I be notified about my favourite seller?"
                    date: "2021-04-23 12:39:41"
                  - sender: 'rickwheels'
                    text: "Yes, you should be notified everytime a favourite seller of yours creates a new auction."
                    date: "2021-04-23 12:59:24"

    post:                    
      operationId: R506
      summary: 'R506: Send Help Message'
      description: 'Send a new Help Message to a given user. Access: ADM'
      tags:
        - 'M05: Help Messages'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                recipient: 
                  type: string
                text:
                  type: string
              required:
                - recipient
                - text

      responses:
        '200':
          description: 'OK, after processing the help message.'
          content:
            application/json:
              schema:
                type: object
                properties:
                  result:
                    type: string
                example:
                  - result: 'success' 
  
  /api/admin/{username}/reports:
    get:
      operationId: R710
      summary: 'R710: View Pending Reports'
      description: 'View Pending Reports from users. Access: ADM'
      tags:
        - 'M07: Administration'

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Ok. Show Reports'
          content:
            application/json:
              schema:
                type: array
                items:
                  type: object
                  properties:
                    reporter:
                      type: string
                    context:
                      type: string
                    reason:
                      type: string
                example:
                  - reporter: 'rickwheels'
                    context: "Auction #993"
                    reason: "This guy is trying to sell a fake fiat model! Stop it!!"
 
```

# A8: Vertical Prototype

The prototype developed in this artefact includes the implementation of some user stories to validate the architecture defined and learn the usage of the technologies required by this project. It includes the implementation of pages of visualization and the possibility to interact with some functionalities. Besides this, the access control of the website pages is also implemented, along with a presentation of the error and success messages.

## 1. Implemented Features

### 1.1. Implemented User Strories

| User Story reference | Name                   | Priority | Description   |
| -------------------- | ---------------------- | -------- | ------------- |
| US001                | See Home               | High     | As a User, I want to access the website homepage, so that I can have an overview of the ongoing auctions and links for the other pages.|
| US002                | Advanced Search        | High     | As a User, I want to search for all the public information, so that I can filter the auctions by the highest bids, the creation date, the car model brand, scale, colour, seller, or the remaining time. |
| US003                | Auction Page           | High     | As a User, I want to be able to see an auction’s information, so that I can know more about the car model being sold. |
| US004                | See About Us           | Medium   | As a User, I want to access the About Us page, so that I can see a complete website's description.|
| US005                | Profile Page           | Medium   | As a User, I want to see the profile page of another user, so that I can search all the auctions from this chosen user. |
| US006                | FAQ Page               | Low      | As a User, I want to access the FAQ, so that I can see Frequently Asked Questions about the website. |
| US101                | Sign-In                | High     | As a Visitor, I want to log in to the system, so that I can access privileged features. |
| US102                | Sign-Up                | High     | As a Visitor, I want to register myself into the system, so that I can store all my data in a personal account.|
| US300                | Profile Page           | High     | As a Registered User, I want to have a profile page, so that I can view and update my personal information, favourites, and statistics. |
| US301                | Logout                 | High     | As a Registered User, I want to logout, so that I can leave the system. |
| US401                | Create an Auction      | High     | As a Seller, I want to create an auction, so that I can sell a model car. |
| US403                | "Buy Now" Option       | Low      | As a Seller, I want to have the option to set a "Buy Now" price for the auction, so that I can give the opportunity to sell the car model instantaneously. |
| US501                | Bid in a given auction | High     | As a Bidder, I want to bid in a given auction, so that I can try to buy the given model car. |
| US503                | Comment an auction     | Low      | As a Bidder, I want to write a comment in an ongoing auction, so that the other users can be informed of my interest. |

### 1.2. Implemented Web Resources


**Module M01: Static pages**

| Web Resource Reference | URL              |
| ---------------------- | ---------------- |
| [R101: View home page](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification)   |  [/](http://lbaw2155.lbaw-prod.fe.up.pt/) |
| [R102: About Us Page](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification)    |  [/about](http://lbaw2155.lbaw-prod.fe.up.pt/about) |
| [R103: FAQs Page](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification)        |  [/faqs](http://lbaw2155.lbaw-prod.fe.up.pt/faqs) |

**Module M02: Authentication**

| Web Resource Reference | URL |
| ---------------------- | ---- |
| [R201: Login Form](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification) | [/login](http://lbaw2155.lbaw-prod.fe.up.pt/login) |
| [R202: Login Action](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification) | POST /login |
| [R203: Logout Action](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification) | POST /logout |
| [R204: Signup Form](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification) | [/signup](http://lbaw2155.lbaw-prod.fe.up.pt/signup) |
| [R205: Signup Action](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification) | POST /signup |

**Module M03: Auctions**

| Web Resource Reference | URL |
| ---------------------- | ---- |
| [R301: View search page](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification)   |  [/auctions/search](http://lbaw2155.lbaw-prod.fe.up.pt/auctions/search) |
| [R302: View auction page](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification)    |  [/auctions/{id}](http://lbaw2155.lbaw-prod.fe.up.pt/auctions/1) |
| [R304: Bid in auction](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification)        |  POST /auctions/{id}/bids 
| [R309: Create new auction](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification)       |  [/auctions/create](http://lbaw2155.lbaw-prod.fe.up.pt/auctions/create) |
| [R310: Create new auction Action](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification)       |  POST /auctions/create |
| [R311: Get all featured auctions](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification)       |  GET /api/auctions/featured |
| [R312: Get search results](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification)       |  GET /api/auctions/search 
| [R314: View auction bid history](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification)       |  GET /api/auctions/{id}/bids
| [R316: View all comments in auction](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification)       |  GET /api/auctions/{id}/comments |
| [R317: Comment in auction](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification)       |  POST /api/auctions/{id}/comments
| [R321: Available Colours](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification)       |  GET /api/colours |
| [R322: Available Brands](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification)       |  GET /api/brands |
| [R323: Available Scales](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification)       |  GET /api/scales |
| [R323: Available Sellers](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification)       |  GET /api/sellers |


**Module M04: Users**

| Web Resource Reference | URL  |
| -----------------------| ---- |
| [R401: View user profile](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification) | [/users/{username}](http://lbaw2155.lbaw-prod.fe.up.pt/users/rkemmey1x)
| [R416: User bid history](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification) | GET /api/users/{username}/bids |
| [R417: Auctions created by the user](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification) | GET /api/users/{username}/auctions
| [R418: User Favourite Auctions](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification) | GET /api/users/{username}/fav_auctions |
| [R421: User Favourite Sellers](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification) | GET /api/users/{username}/fav_sellers |
| [R424: Ratings given to the user](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification) | GET /api/users/{username}/ratings |
| [R425: Ratings given by the user](https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155/-/wikis/eap#a7-high-level-architecture-privileges-web-resources-specification) | GET /api/users/{username}/rated |

## 2. Prototype

The prototype is available at http://lbaw2155.lbaw-prod.fe.up.pt/

Credentials:

* regular user: aflowerden0@posterous.com/aflowerden0
* regular user: rkemmey1x@homestead.com/rkemmey1x
* regular user: fbrauned@cam.ac.uk/fbrauned

The code is available at https://git.fe.up.pt/lbaw/lbaw2021/lbaw2155

## Revision History

Changes made to the first submission:

## Team
* Eduardo Brito
    * [up201806271@edu.fe.up.pt](mailto:up201806271@edu.fe.up.pt)
    * [up201806271@up.pt](mailto:up201806271@up.pt)
* Paulo Ribeiro
    * [up201806505@edu.fe.up.pt](mailto:up201806505@edu.fe.up.pt)
    * [up201806505@up.pt](mailto:up201806505@up.pt)
* Pedro Ferreira (Editor)
    * [up201806506@edu.fe.up.pt](mailto:up201806506@edu.fe.up.pt)
    * [up201806506@up.pt](mailto:up201806506@up.pt)
* Pedro Ponte
    * [up201809694@edu.fe.up.pt](mailto:up201809694@edu.fe.up.pt)
    * [up201809694@up.pt](mailto:up201809694@up.pt)
----
GROUP 2155, 01/05/2021