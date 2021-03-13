# ER: Requirements Specification Component

An online bidding platform destined for car model lovers, allowing them to sell or complete their private collections, by participating in real-time traditional auctions and interacting with other worldwide collectors.

## A1: CarBay

This project aims to develop a website where collection lovers can participate and bid in online auctions of famous collection car models.

In today’s world, vintage collections are widely searched and desired by aesthetics enthusiasts. A web-based aggregation system where users can participate in auctions can be of enormous value, allowing them to extend their private car collections or sell their assets in real-time. This idea becomes more relevant since there is no other online system alike for this growing market.

There will be three different types of users, being the first the administrators, who have permissions to manage ongoing auctions, suspending or rescheduling them, to assist or block users and update/delete website content.

Secondly, a registered user can create, as a seller, and participate, as a bidder, in their favourite auctions. These traditional auctions stay available for the time set defined by the seller, and when it closes, the highest bidder wins. Unlike other types of auctions, this one does not increase the time at the final seconds and the ending hour is fixed. Additional features are the “Buy Now” option, which ends the auction right away, setting the maximum allowed bid, or the “Feedback Loop”, which allows the users to give real-time feedback during the auction. Registered users have access to their profiles with their auctions’ history and other related information. The Google authentication API may be provided for the users to log in and use their Google account basic profile information.

Finally, besides being able to browse through past and live auctions, the rest of the website visitors can also see the website content, without being able to explicitly interact with it. The content may be searched and ordered using advanced criteria, for example, by the auctions' highest bids, the creation date, the car model brand, scale, colour or seller, the remaining time, and many other terms.

## A2: Actors and User stories

Specification of the actors, their user stories, and supplementary requirements are contained in this artifact, serving as agile documentation of the project requirements. This way, every featured idea of the project is presented in this section, along with their description and priority.

### 2.1 Actors:

![Figure 1: Actors](actors.png)

Figure 1: Actors.

| Identifier | Description | Examples |
| ------ | ------ | ----- |
| User          | Generic user who has access to public information, such as the auctions, users’ profiles, and the advanced search                                                                                                       | n/a            |
| Visitor       | Unauthenticated user that can register itself (sign-up) or sign-in in the system. A visitor can’t participate in auctions or interact with the other users.                                                             | n/a            |
| Administrator | Authenticated user who has permission to manage ongoing auctions, suspending or rescheduling them, to assist or block users, and to update/delete website content.                                                       | Admin          |
| Registered    | Authenticated user that can participate in auctions, and interact with other users. It’s associated with a personal profile, where their auctions’ history, favourite auctions and sellers, and statistics can be seen. | WheelsAddict   |
| Seller        | Registered user that created an auction, where he is selling one or more model cars. He has access to the detailed data of the auction, like the number of bids, the respective bidders, or the price variation.        | CarBoss        |
| Bidder        | Registered user that can bid in a given auction and give feedback during the events.                                                                                                                                    | WheelsAddict   |
| Google OAuth API           | External OAuth API which is used to register or authenticate into the system.                                                                                                                                           | Google         |

Table 1: Actors Description.

### 2.2 User Stories

For this system, are considered the user stories that are presented in the following sections.

#### User

| Identifier | Name            | Priority | Description |
| ---------- | --------------- | -------- | ----------- |
| US001       | See Home        | High     | As a User, I want to access the website homepage, so that I can have an overview of the ongoing auctions and links for the other pages.|
| US002       | Advanced Search | High     | As a User, I want to search for all the public information, so that I can filter the auctions by the highest bids, the creation date, the car model brand, scale, colour, seller, or the remaining time. |
| US003       | Auction Page   | High     | As a User, I want to be able to see an auction’s information, so that I can know more about the car model being sold. |
| US004       | See About Us    | Medium     | As a User, I want to access the About Us page, so that I can see a complete website's description.|
| US005       | Profile Page    | Medium   | As a User, I want to see the profile page of another user, so that I can search all the auctions from this chosen user. |
| US006       | FAQ Page        | Low      | As a User, I want to access the FAQ, so that I can see Frequently Asked Questions about the website. |

Table 2: User's User Stories. 

#### Visitor

| Identifier | Name                      | Priority | Description |
| ---------- | ------------------------- | -------- | ----------- |
| US101       | Sign-In                   | High     | As a Visitor, I want to log in to the system, so that I can access privileged features. |
| US102       | Sign-Up                   | High     | As a Visitor, I want to register myself into the system, so that I can store all my data in a personal account.|
| US103       | Sign-In with external API | Low      | As a Visitor, I want to sign-in through my Google account, so that I can access privileged features. |
| US104       | Sign-Up with external API | Low      | As a Visitor, I want to register using my Google account, so that I can store all my data in the system. |

Table 3: Visitor's User Stories. 

#### Administrator

| Identifier | Name            | Priority | Description |
| ---------- | --------------- | -------- | ----------- |
| US201       | Manage auctions | High     | As an Administrator, I want to manage auctions, so that I can suspend or reschedule an auction. |
| US202       | Logout                     | High     | As an Administrator, I want to logout, so that I can leave the system. |
| US203       | Answer User Doubt     | Low   | As an Administrator, I want to answer a user's doubt in a private chat, so that I can clarify his questions. |
| US204       | User Reports    | Low      | As an Administrator, I want to see users' reports, so that I can review users' activity and decide to ban them. |
| US205       | Remove comments | Low     | As an Administrator, I want to remove a comment on a user profile, so that there are no inappropriate observations on the website. |
| US206       | Notifications | Low | As an Administrator, I want to receive notifications about questions received or user reports, so that I can be aware of what's happening. |

Table 4: Administrator's User Stories.

#### Registered

| Identifier | Name                       | Priority | Description |
| ---------- | -------------------------- | -------- | ----------- |
| US300       | Profile Page               | High     | As a Registered User, I want to have a profile page, so that I can view and update my personal information, favourites, and statistics. |
| US301       | Logout                     | High     | As a Registered User, I want to logout, so that I can leave the system. |
| US302       | Manage Favourite Auctions    | Medium     | As a Registered User, I want to add/remove a given auction to/from my Favourite Auctions, so that I can be notified of important related events. |
| US303       | Manage Favourite Sellers     | Medium   | As a Registered User, I want to add/remove a given seller to/from my Favourite Sellers, so that I can follow/unfollow his new auctions. |
| US304       | Rating Users               | Low   | As a Registered User, I want to write comments on the profile of a given user and rate him, so that other users can know if he is trustworthy. |
| US305       | Remove Comments            | Low   | As a Registered User, I want to remove my comments on the profile of a given user, so that it reflects my change of opinion. |
| US306       | Question Administrators     | Low   | As a Registered User, I want to ask the administrators my questions in a private chat, so that I can clarify my doubts. |
| US307       | Statistics                 | Low   | As a Registered User, I want to see my statistics, so that I can have an overview of my auctions' and bids' history and money spent/earned. |
| US308       | Notifications               | Low      | As a Registered User, I want to receive notifications about favourite auctions and related activity, so that I can be aware of what's happening. |
| US309       | Report Users               | Low   | As a Registered User, I want to report a given user, so that administrators can review this user's activity and ban him if needed. |
| US310       | Delete Profile               | Low   | As a Registered User, I want to be able to delete my account, so that my relationship with the website is over. |

Table 5: Registered's User Stories

#### Seller

| Identifier | Name | Priority | Description |
| ---------- | ------- | -------- | ------------- |
| US401       | Create an Auction | High | As a Seller, I want to create an auction, so that I can sell a model car. |
| US402       | Access to Auction Statistics | Low | As a Seller, I want to access private auction data (like the number of bids, the respective bidders, or the price variation), so that I can have a better perception of the auction details. |
| US403       | "Buy Now" Option | Low  | As a Seller, I want to have the option to set a "Buy Now" price for the auction, so that I can give the opportunity to sell the car model instantaneously. |

Table 6: Seller's User Stories.

#### Bidder

| Identifier | Name                   | Priority | Description |
| ---------- | ---------------------- | -------- | ----------- |
| US501       | Bid in a given auction | High     | As a Bidder, I want to bid in a given auction, so that I can try to buy the given model car. |
| US502       | "Buy Now" | Low     | As a Bidder, I want to trigger the "Buy Now" option if available, so that I can buy the car model without having to wait for the end of the auction. |
| US503       | Comment an auction     | Low   | As a Bidder, I want to write a comment in an ongoing auction, so that the other users can be informed of my interest. |

Table 7: Bidder's User Stories.

### 2.3 Supplementary requirements:

This annex contains business rules, technical requirements, and other non-functional requirements on the project.

#### Business rules

| Identifier | Name                     | Description |
| ---------- | ------------------------ | ----------- |
| BR01       | Auction finish date      | The auction finish date must be greater than the start date of the auction. |
| BR02       | Auction duration | The auction needs to have a minimum time duration of one day and a maximum of 7 days. |
| BR03       | Minimum bid              | The auction must have an initial minimum value of 1 euro from where bids can be placed. |
| BR04       | Auction requirements     | Only registered and non-blocked members are allowed to bid or create new auctions. |
| BR05       | Bidders details          | Only the creator has access to the profile of those who bid on their auction. |
| BR06       | Bids in growing order    | A new bid must have a greater value than the previous set bid. |
| BR07       | Auction self bid         | The seller cannot bid on his own auction. |
| BR08       | Deleted user             | When a user is deleted, active auctions and bids are canceled, its profile info is deleted, but not its history (past auctions/bids). |

Table 8: Business rules.

#### Technical requirements

| Identifier | Name            | Description |
| ---------- | --------------- | ----------- |
| TR01       | Availability    | The system must be available ideally all the time and prepared to handle and continue operating when runtime errors occur. |
| TR02       | Security        | The system shall protect information from unauthorized access through the use of an authentication and verification system. |
| TR03       | Data Consistency   | The system must be synchronous and consistent for all the users (for example, the remaining time of the auction should be the same for all users). |

Table 9: Technical requirements.

#### Restrictions

| Identifier | Name     | Description |
| ---------- | -------- | ----------- |
| C01        | Project Deadline | The system should be ready to be used at the project submission deadline (31/05/2021) to be able to buy or sell car models. |
| C03        | Artifacts Delivery | All the intermediate deadlines must be met, according to the course agenda. |
| C03        | Development Interruptions | The development activities will be interrupted during the Easter, and the LBAW exam. |

Table 10: Restrictions.

## A3: User Interface Prototype

This section pretends to associate the page design with the user stories described in the previous artefact, alongside new ones that came to our mind during this artefact’s development. The prototype must allow us to test the user interface’s main interactions and the navigation between the distinct pages.
 
In this artefact, we include a description of the website interface and its common features, using some screenshots to highlight the main functionalities. We also include a sitemap presenting the overall structure of the website from the user’s viewpoint, containing all the pages the site has. At last, we have organized a sequence of wireflows initially designed to show our website design and interface main ideas.
 
At the end of this document, there are prints of the website pages implemented for the prototype.


### 3.1 Interface and common features

Carbay is a web application based on HTML5, JavaScript, CSS, and PHP.

As requested by the project enunciate, the user interface of the website was implemented using the Bootstrap framework.

All the website pages will have the following common elements, whose positions are highlighted in the figure:

| ![Figure 2: Interface's guidelines](DesktopImages/Homepage-Numbers.png) | ![Figure 2: Interface's guidelines](MobileImages/M-Homepage-Numbers.png) |
|----|----|

Figure 2: Interface's guidelines

1. **Logo:** When clicked, it redirects the user to the homepage
2. **Navbar:**
    * From a visitor perspective, it contains links to the search, login, and signup pages
    * When logged in, it contains links to the search, create auction and profile pages, and also a notifications icon and a logout button.
3. **Content:** Depends on the current page
4. **Footer:**
    * From a visitor perspective, it contains links to About Us and FAQs pages
    * When logged in, it also contains a link to the Help page.

Some common characteristics between all the pages are:
* Responsive behaviour, since every page adapts itself to the size of the screen, therefore allowing the website to be accessed by different devices (laptop, tablets, smartphones...)
* In order to keep the website consistent, and to enhance the user experience, the common elements of the pages maintain their position - the navbar is fixed on the top of the screen and the footer at the end.
* Consistency of the page components - we decided to maintain the design of the elements composing the page, by using only our theme’s colours, a centred vision of the content of the page, a rectangular shape for buttons and sections, and the same text font (“Nunito Sans”).
* Simplicity of the user interface - the majority of the links are represented by icons, representative of the target page’s functionalities, and no page contains too much-concentrated information.
* Apart from the Homepage, every page contains a breadcrumb, helping locate the user on the website.


### 3.2 Sitemap

![Figure 3: Sitemap](wireflows/sitemap.png)

Figure 3: Sitemap.


### 3.3 Wireflows

![Figure 4: Wireflow centered on the visitor's options.](wireflows/w2.png)

Figure 4: Wireflow centered on the visitor's options.

![Figure 5: Wireflow for the login and sign up interactions.](wireflows/w3.png)

Figure 5: Wireflow for the log-in and sign-up interactions.

![Figure 6: Wireflow centered on the admin's options.](wireflows/w4.png)

Figure 6: Wireflow centered on the admin's options.

![Figure 7: Wireflow centered on the registered user's options.](wireflows/w5.png)

Figure 7: Wireflow centered on the registered user's options.

![Figure 8: Wireflow centered on the user's profile options.](wireflows/w6.png)

Figure 8: Wireflow centered on the user's profile options.

![Figure 9: Wireflow centered on the end of an auction.](wireflows/w7.png)

Figure 9: Wireflow centered on the end of an auction.

[InVision Project](https://lbaw2155.invisionapp.com/freehand/lbaw2155-G5KykIqjB)


### 3.4 Interfaces

The following interfaces represent our platform's look and available features.

  - [UI01: Homepage](#ui01-homepage)
  - [UI02: About Us](#ui02-about-us)
  - [UI03: Faqs](#ui03-faqs)
  - [UI04: Help](#ui04-help)
  - [UI05: Log In](#ui05-log-in)
  - [UI06: Sign Up](#ui06-sign-up)
  - [UI07: Search](#ui07-search)
  - [UI08: Auction Page - Chat](#ui08-auction-page---chat)
  - [UI09: Auction Page - Bid History](#ui09-auction-page---bid-history)
  - [UI10: Create Auction - General Info](#ui10-create-auction---general-info)
  - [UI11: Create Auction - Description](#ui11-create-auction---description)
  - [UI12: Profile](#ui12-profile)
  - [UI13: Edit Profile](#ui13-edit-profile)
  - [UI14: Profile - Bid History](#ui14-profile---bid-history)
  - [UI15: Profile - Auctions Created](#ui15-profile---auctions-created)
  - [UI16: Profile - Favourite Auctions](#ui16-profile---favourite-auctions)
  - [UI17: Profile - Favourite Sellers](#ui17-profile---favourite-sellers)
  - [UI18: Profile - Users Ratings](#ui18-profile---users-ratings)
  - [UI19: Profile - Users Rated](#ui19-profile---users-rated)
  - [UI20: Admin Panel - Users Management](#ui20-admin-panel---users-management)
  - [UI21: Admin Panel - Auctions Management](#ui21-admin-panel---auctions-management)
  - [UI22: Admin Panel - Reports](#ui22-admin-panel---reports)
  - [UI23: Admin Panel - Help](#ui23-admin-panel---help)
  - [UI24: Error 404](#ui24-error-404)

 
#### UI01: Homepage

| ![Homepage](DesktopImages/Homepage.png) | ![Homepage](MobileImages/M-Homepage.png) |
|----|----|

Figure 10: [Homepage](http://lbaw2155-piu.lbaw-prod.fe.up.pt/)

#### UI02: About Us

| ![AboutUs](DesktopImages/About.png) | ![AboutUs](MobileImages/M-About.png) |
|----|----|

Figure 11: [About Us](http://lbaw2155-piu.lbaw-prod.fe.up.pt/about.php)

#### UI03: Faqs

| ![Faqs](DesktopImages/Faqs.png) | ![Faqs](MobileImages/M-Faqs.png) |
|----|----|

Figure 12: [Faqs](http://lbaw2155-piu.lbaw-prod.fe.up.pt/faqs.php)

#### UI04: Help

| ![Help](DesktopImages/Help.png) | ![Help](MobileImages/M-Help.png) |
|----|----|

Figure 13: [Help](http://lbaw2155-piu.lbaw-prod.fe.up.pt/help.php)

#### UI05: Log In

| ![Login](DesktopImages/Login.png) | ![Login](MobileImages/M-Login.png) |
|----|----|

Figure 14: [Log In](http://lbaw2155-piu.lbaw-prod.fe.up.pt/login.php)

#### UI06: Sign Up

| ![SignUp](DesktopImages/SignUp.png) | ![SignUp](MobileImages/M-SignUp.png) |
|----|----|

Figure 15: [Sign Up](http://lbaw2155-piu.lbaw-prod.fe.up.pt/signup.php)

#### UI07: Search

| ![Search](DesktopImages/Search.png) | ![Search](MobileImages/M-Search.png) |
|----|----|

Figure 16: [Search](http://lbaw2155-piu.lbaw-prod.fe.up.pt/search.php)

#### UI08: Auction Page - Chat

| ![Auction-Chat](DesktopImages/Auction-Chat.png) | ![Auction-Chat](MobileImages/M-Auction-Chat.png) |
|----|----|

Figure 17: [Auction](http://lbaw2155-piu.lbaw-prod.fe.up.pt/auction.php)

#### UI09: Auction Page - Bid History

| ![Auction-BidHistory](DesktopImages/Auction-BidHistory.png) | ![Auction-BidHistory](MobileImages/M-Auction-BidHistory.png) |
|----|----|

Figure 18: [Auction](http://lbaw2155-piu.lbaw-prod.fe.up.pt/auction.php)

#### UI10: Create Auction - General Info

| ![CreateAuction-GeneralInfo](DesktopImages/CreateAuction-GeneralInfo.png) | ![CreateAuction-GeneralInfo](MobileImages/M-CreateAuction-GeneralInfo.png) |
|----|----|

Figure 19: [Create Auction](http://lbaw2155-piu.lbaw-prod.fe.up.pt/create-auction.php)

#### UI11: Create Auction - Description

| ![CreateAuction-Description](DesktopImages/CreateAuction-Description.png) | ![CreateAuction-Description](MobileImages/M-CreateAuction-Description.png) |
|----|----|

Figure 20: [Create Auction](http://lbaw2155-piu.lbaw-prod.fe.up.pt/create-auction.php)

#### UI12: Profile

| ![Profile](DesktopImages/Profile.png) | ![Profile](MobileImages/M-Profile.png) |
|----|----|

Figure 21: [Profile](http://lbaw2155-piu.lbaw-prod.fe.up.pt/profile.php)

#### UI13: Edit Profile

| ![EditProfile](DesktopImages/EditProfile.png) | ![EditProfile](MobileImages/M-EditProfile.png) |
|----|----|

Figure 22: [Edit Profile](http://lbaw2155-piu.lbaw-prod.fe.up.pt/edit-profile.php)

#### UI14: Profile - Bid History

| ![Profile-BidHistory](DesktopImages/Profile-BidHistory.png) | ![Profile-BidHistory](MobileImages/M-Profile-BidHistory.png) |
|----|----|

Figure 23: [Profile](http://lbaw2155-piu.lbaw-prod.fe.up.pt/profile.php)

#### UI15: Profile - Auctions Created

| ![Profile-AuctionsCreated](DesktopImages/Profile-AuctionsCreated.png) | ![Profile-AuctionsCreated](MobileImages/M-Profile-AuctionsCreated.png) |
|----|----|

Figure 24: [Profile](http://lbaw2155-piu.lbaw-prod.fe.up.pt/profile.php)

#### UI16: Profile - Favourite Auctions

| ![Profile-FavouriteAuctions](DesktopImages/Profile-FavouriteAuctions.png) | ![Profile-FavoriteAuctions](MobileImages/M-Profile-FavoriteAuctions.png) |
|----|----|

Figure 25: [Profile](http://lbaw2155-piu.lbaw-prod.fe.up.pt/profile.php)

#### UI17: Profile - Favourite Sellers

| ![Profile-FavouriteSellers](DesktopImages/Profile-FavouriteSellers.png) | ![M-Profile-FavoriteSellers](MobileImages/M-Profile-FavoriteSellers.png) |
|----|----|

Figure 26: [Profile](http://lbaw2155-piu.lbaw-prod.fe.up.pt/profile.php)

#### UI18: Profile - Users Ratings

| ![Profile-UserRatings](DesktopImages/Profile-UserRatings.png) | ![M-Profile-UserRatings](MobileImages/M-Profile-UserRatings.png) |
|----|----|

Figure 27: [Profile](http://lbaw2155-piu.lbaw-prod.fe.up.pt/profile.php)

#### UI19: Profile - Users Rated

| ![Profile-UsersRated](DesktopImages/Profile-UsersRated.png) | ![Profile-UsersRated](MobileImages/M-Profile-UsersRated.png) |
|----|----|

Figure 28: [Profile](http://lbaw2155-piu.lbaw-prod.fe.up.pt/profile.php)

#### UI20: Admin Panel - Users Management

| ![Admin-UsersManagement](DesktopImages/Admin-UsersManagement.png) | ![Admin-UsersManagement](MobileImages/M-Admin-UsersManagement.png) |
|----|----|

Figure 29: [Admin Panel](http://lbaw2155-piu.lbaw-prod.fe.up.pt/admin.php)

#### UI21: Admin Panel - Auctions Management

| ![Admin-AuctionsManagement](DesktopImages/Admin-AuctionsManagement.png) | ![Admin-AuctionsManagement](MobileImages/M-Admin-AuctionsManagement.png) |
|----|----|

Figure 30: [Admin Panel](http://lbaw2155-piu.lbaw-prod.fe.up.pt/admin.php)

#### UI22: Admin Panel - Reports

| ![Admin-Reports](DesktopImages/Admin-Reports.png) | ![Admin-Reports](MobileImages/M-Admin-Reports.png) |
|----|----|

Figure 31: [Admin Panel](http://lbaw2155-piu.lbaw-prod.fe.up.pt/admin.php)

#### UI23: Admin Panel - Help

| ![Admin-Help](DesktopImages/Admin-Help.png) | ![Admin-Help](MobileImages/M-Admin-Help.png) |
|----|----|

Figure 32: [Admin Panel](http://lbaw2155-piu.lbaw-prod.fe.up.pt/admin.php)

#### UI24: Error 404

| ![Error404](DesktopImages/Error404.png) | ![Error404](MobileImages/M-Error404.png) |
|----|----|

Figure 33: [Error 404](http://lbaw2155-piu.lbaw-prod.fe.up.pt/404.php)

## Revision History

Changes made to the first submission:

## Team
* Eduardo Brito (Editor)
    * [up201806271@fe.up.pt](mailto:up201806271@fe.up.pt)
    * [up201806271@g.uporto.pt](mailto:up201806271@g.uporto.pt)
* Paulo Ribeiro
    * [up201806505@fe.up.pt](mailto:up201806505@fe.up.pt)
    * [up201806505@g.uporto.pt](mailto:up201806505@g.uporto.pt)
* Pedro Ferreira
    * [up201806506@fe.up.pt](mailto:up201806506@fe.up.pt)
    * [up201806506@g.uporto.pt](mailto:up201806506@g.uporto.pt)
* Pedro Ponte
    * [up201809694@fe.up.pt](mailto:up201809694@fe.up.pt)
    * [up201809694@g.uporto.pt](mailto:up201809694@g.uporto.pt)
----
GROUP 2155, 13/03/2021