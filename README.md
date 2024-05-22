# ITA Profiles FRONTEND

Welcome to the ITA FRONTEND GitHub repository!

This repository houses the source code for the IT Academy's profiles. Thi platform enables event recruiters collaborating with the IT academy to have quick access to all candidates, allowing them to filter and communicate with them effortlessly. For students, the aim is to enhance the visibility of their profiles and thereby improve their employability.

IT Academy is a leading educational institution of Barcelona dedicated to providing tech education.

**The code is developed by students who have completed the IT Academy Bootcamp** and are currently in the project phase. In these projects, there is a Product Owner and a Scrum Master to enable students to apply their knowledge in a real-world environment.

## Demo

--

## Screenshots

--

## Installation

```console
git clone --
npm i
npm run dev
```

_Note: The next steps are only needed while there isn't a backend API_

If we need to run json-server we must start a local server to keep track of the `db.json` file. For that we need to execute this command on our IDE terminal. This will run the server in `localhost:3000`.

`npx json-server --watch db.json -m ./node_modules/json-server-auth`

If we need to change the port of the server we add `-p xxxx`. The next example will run the server on `localhost:3001`.

`npx json-server --watch -p 3001 db.json -m ./node_modules/json-server-auth`

## Contribution Guidelines

Contributions are always welcome!

To ensure a smooth and organized development process, please follow these guidelines when contributing:

### Folder Structure

- Components: All React components should be created within the /components folder. These components should focus solely on rendering and presenting data. They should not contain any logic or API calls.
- Pages: If it is necessary to create a new page, please do so within the /pages folder. Pages should serve as the top-level components that define the structure of a route and may contain a composition of components. Keep pages clean and avoid adding complex logic directly to them.

--

### Separation of Concerns

Logic and API Calls: Components should not contain logic or make API calls directly. For handling application logic and data fetching, utilize either the React Context API or Redux state management. Create separate files for actions, reducers, and selectors as needed within the Redux structure.
Redux: If you're working on state management, follow the Redux pattern for actions and reducers. Ensure that reducers are pure functions and keep state updates predictable.

### Git Workflow

1. Branches: When working on a new feature or bug fix, create a new branch from the dev branch with a descriptive name, such as feature/add-user-profile. Make your changes within this branch.

2. Commits: Make frequent, well-documented commits. Use clear and concise commit messages that describe the purpose of each commit.

3. Pull Requests: Submit a pull request when your feature or bug fix is ready for review. Include a description of your changes in the pull request, and reference any related issues, if applicable.

### Code Quality

1. Code Style: Maintain a consistent code style throughout the project. Use appropriate naming conventions, indentation, and follow any established coding standards.

2. Code Reviews: Be open to feedback during code reviews. Reviewers may suggest improvements or changes to ensure code quality and maintainability.

By following these contribution guidelines, you'll help maintain a clean and organized codebase,

## Used By

This project is being used by IT Academy at Barcelona Activa

## Acknowledgements

To all the students whose hard work makes these projects possible and move forward.

## FAQ

#### What are the requirements to participate in projects?

Complete the React specialization at IT Academy.

#### Why should I collaborate on this project?

Because it provides a real-world environment to apply all the concepts learned in the bootcamp. It also allows for learning more advanced concepts and facing real-life situations that may occur in a company.
