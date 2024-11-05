
# ITA Profiles

- [Introduction](#introduction)
- [How to install the project](#how-to-install-the-project)
- [Local Addresses](#local-addresses)
- [Demo](#demo)
- [Screenshots](#screenshots)
- [Installation](#installation)
- [Contribution Guidelines](#contribution-guidelines)
- [Documentation](#documentation)
- [Links of interest](#links-of-interest)
- [Used By](#used-by)
- [Acknowledgements](#acknowledgements)
- [FAQ](#faq)

## Introduction

ITA Profiles is a project from IT Academy post-specialization course that allows students from our academy to gain experience in a team that is using SCRUM methodology, and several technologies often used by most tech companies. So, the main focus of the project is to help grow our students so they can learn to work in a team, question, think solutions and face the usual challenges.

The project now integrates both frontend and backend functionalities to provide a seamless experience for users.


## How to install the project

We use docker containers to share the same versions of PHP and MySQL around all the team members. After cloning the project in your local environment, follow these steps:

1. Install Docker by following the instructions [here](https://docs.docker.com/engine/install/).

2. Once Docker is installed, go to the project's root folder and build the containers by running:

```shell
docker compose up --build -d
```

3. Verify that the containers are running by executing:

```shell
docker ps
```

4. You can now run commands inside the container using the following format:

```shell
docker exec -it <app-container-name> <the-command>
```

For example:

```shell
docker exec -it php composer install
docker exec -it php php artisan migrate:fresh
docker exec -it php php artisan db:seed
```

### Local Addresses

After the containers are up, you can access various tools locally:

- Local Laravel API: [http://localhost](http://localhost)
- Local Swagger documentation: [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)
- Local PHPMyAdmin (MySQL): [http://localhost:9015](http://localhost:9015)
- Code Coverage: file:///path/to/your/project/tests/coverage/index.html

#### PHPMyAdmin Credentials

Use the following credentials to access PHPMyAdmin:

```
Host: mysql
User: user
Password: password
```

#### GitHub Token

Some functionnalities require a GitHub token. If you don't have one, you can generate one here: [https://github.com/settings/tokens](https://github.com/settings/tokens). You can then use it in the `.env` file.

## Demo

--

## Screenshots

--

## Installation

To install the frontend, follow these steps:

```console
git clone --
npm i
npm run dev
```

If a backend API is not available, you can use json-server. Start a local server to keep track of the `db.json` file:

```console
npx json-server --watch db.json -m ./node_modules/json-server-auth
```

Change the port of the server if needed:

```console
npx json-server --watch -p 3001 db.json -m ./node_modules/json-server-auth
```

## Contribution Guidelines

Contributions are always welcome! Please follow these guidelines:

### Folder Structure

- Components: All React components should be created within the /components folder. These components should focus solely on rendering and presenting data. They should not contain any logic or API calls.
- Pages: Create new pages within the /pages folder. Pages should serve as the top-level components that define the structure of a route and may contain a composition of components. Keep pages clean and avoid adding complex logic directly to them.

### Separation of Concerns

- Logic and API Calls: Components should not contain logic or make API calls directly. Utilize either the React Context API or Redux state management for handling application logic and data fetching. Create separate files for actions, reducers, and selectors as needed within the Redux structure.
- Redux: Follow the Redux pattern for actions and reducers. Ensure that reducers are pure functions and keep state updates predictable.

### Git Workflow

1. Branches: Create a new branch from the dev branch with a descriptive name for new features or bug fixes.
2. Commits: Make frequent, well-documented commits with clear and concise messages.
3. Pull Requests: Submit a pull request when your feature or bug fix is ready for review. Include a description of your changes and reference any related issues.

### Code Quality

1. Code Style: Maintain a consistent code style throughout the project. Use appropriate naming conventions, indentation, and follow any established coding standards.
2. Code Reviews: Be open to feedback during code reviews to ensure code quality and maintainability.

## Documentation

Please follow the coding guidelines defined in the [documentation](./docs/coding-guidelines.md).

## Links of interest:


- [Swagger](https://itaperfils.eurecatacademy.org/api/documentation): Bakend Documentation

- [Figma](https://www.figma.com/file/DynJHHUlOiqx3F5h9dtvAW/Projectes-IT-Academy?type=design&node-id=1-5&mode=design&t=0Tn11J0k1eOANlsI-0): we take our designs from here

- [Netlify](https://ita-profiles.netlify.app/): we use this to simulate the production URL

- [GitHub Project Table](https://github.com/orgs/IT-Academy-BCN/projects/18): here you'll find the team's issues

## Used By

This project is being used by IT Academy at Barcelona Activa.

## Acknowledgements

Thanks to all the students whose hard work makes these projects possible and move forward.

## FAQ

#### What are the requirements to participate in projects?

Complete the React specialization at IT Academy.

#### Why should I collaborate on this project?

This project provides a real-world environment to apply all the concepts learned in the bootcamp. It also allows for learning more advanced concepts and facing real-life situations that may occur in a company.
