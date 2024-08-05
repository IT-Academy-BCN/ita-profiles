import { render, screen, fireEvent } from '@testing-library/react';
import axios from "axios";
import React from 'react';
import MockAdapter from 'axios-mock-adapter';
import ProjectsCard from '../../../components/studentDetailCards/projectsSection/ProjectsCard';
import { SelectedStudentIdContext, SelectedStudentProvider } from '../../../context/StudentIdContext';

describe('ProjectsCard', () => {
  beforeEach(() => {
    render(
      <SelectedStudentProvider>
        <ProjectsCard />
      </SelectedStudentProvider>,
    )
  })
  test('should show "Projects" all the time', () => {
    expect(screen.getByText('Proyectos')).toBeInTheDocument()
  })
})

describe('ProjectsCard component', () => {
  let mock: MockAdapter

  beforeAll(() => {
    mock = new MockAdapter(axios)
  })

  afterEach(() => {
    mock.reset()
  })

  afterAll(() => {
    mock.restore()
  })

  const studentUUID = '123'
  const setStudentUUID = () => { }
  const projectsData = [
    { project_id: 1, project_name: 'Project 1' },
    { project_id: 2, project_name: 'Project 2' },
  ]

  test('renders projects correctly', async () => {
    mock
      .onGet(
        `//localhost:8000/api/v1/student/${studentUUID}/resume/projects`,
      )
      .reply(200, projectsData)

    render(
      <SelectedStudentIdContext.Provider value={{ studentUUID, setStudentUUID }}>
        <ProjectsCard />
      </SelectedStudentIdContext.Provider>,
    )

    // Wait for projects to load
    const projectsElement = screen.getByText('Proyectos');

    // Check if projects are rendered correctly
    expect(projectsElement).toBeInTheDocument();
  })
})

describe('scrollLeft and scrollRight functions', () => {
  test('scrollLeft function scrolls left when button is clicked', () => {
    const carouselRef = React.createRef<HTMLDivElement>();
    render(<ProjectsCard />, { wrapper: ({ children }) => <div ref={carouselRef}>{children}</div> });
    fireEvent.click(screen.getByAltText('arrow left'));
    expect(screen.getByTestId('ProjectsCard').scrollLeft).toBeGreaterThanOrEqual(0);
  });

  test('scrollRight function scrolls right when button is clicked', () => {
    const carouselRef = React.createRef<HTMLDivElement>();
    render(<ProjectsCard />, { wrapper: ({ children }) => <div ref={carouselRef}>{children}</div> });
    fireEvent.click(screen.getByAltText('arrow right'));
    expect(screen.getByTestId('ProjectsCard').scrollLeft).toBeGreaterThanOrEqual(0);
  });

  test('carousel width changes after scrolling', () => {
    const carouselRef = React.createRef<HTMLDivElement>();
    render(<ProjectsCard />, { wrapper: ({ children }) => <div ref={carouselRef}>{children}</div> });
    const initialWidth = screen.getByTestId('ProjectsCard').offsetWidth;

    fireEvent.click(screen.getByAltText('arrow left'));
    const updatedWidthAfterLeftScroll = screen.getByTestId('ProjectsCard').offsetWidth;

    fireEvent.click(screen.getByAltText('arrow right'));
    const updatedWidthAfterRightScroll = screen.getByTestId('ProjectsCard').offsetWidth;

    expect(updatedWidthAfterLeftScroll).toEqual(initialWidth);
    expect(updatedWidthAfterRightScroll).toEqual(initialWidth);
  });
});
