import { Github, Dots, ArrowLeft, ArrowRight } from '../../../../assets/svg'
import { ArrowRightProjects } from '../../../../assets/img'
import { useAppSelector } from '../../../../hooks/ReduxHooks'
import LoadingSpiner from '../../../atoms/LoadingSpiner'
import { Carousel } from '../../../atoms/Carousel'

const ProjectsCard: React.FC = () => {
    const { studentProjects } = useAppSelector((state) => state.ShowStudentReducer)
    const { projectsData, isLoadingProjects, isErrorProjects } = studentProjects

    const { scrollLeft, scrollRight, carouselRef } = Carousel()

    return (
        <div
            className="carousel-item flex flex-col gap-4"
            data-testid="ProjectsCard"
        >
            <div className="flex justify-between">
                <h3 className="text-lg font-bold">Proyectos</h3>
                <div className="h-3 self-end">
                    <button type="button" onClick={scrollLeft}>
                        <img src={ArrowLeft} alt="arrow left" className="w-5" />
                    </button>
                    <button type="button" onClick={scrollRight}>
                        <img
                            src={ArrowRight}
                            alt="arrow right"
                            className="w-5"
                        />
                    </button>
                </div>
            </div>
            {isLoadingProjects && <LoadingSpiner />}
            {isErrorProjects && (
                <LoadingSpiner
                    textContent="Upss!!"
                    type="loading-bars"
                    textColor="red"
                />
            )}
            {projectsData && (
                <div ref={carouselRef} className="flex gap-3 overflow-x-hidden">
                    {projectsData.map((project) => (
                        <div
                            key={project.uuid}
                            className="flex flex-col gap-1 rounded-xl border border-gray-3 px-5 py-3.5 "
                        >
                            <div className="flex items-center justify-between">
                                <div className="flex w-48 items-center gap-3">
                                    <p className="text-md font-semibold ">
                                        {project.name.slice(0, 15)}
                                    </p>
                                    <a
                                        href={project.github_url}
                                        className="flex items-center"
                                    >
                                        <img
                                            src={Github}
                                            alt="github link"
                                            className="w-6"
                                        />
                                    </a>
                                </div>
                                <button
                                    type="button"
                                    className="-mt-1 flex w-6 self-start"
                                >
                                    <img src={Dots} alt="3 dots" />
                                </button>
                            </div>
                            <p className="text-sm text-gray-3">
                                {project.company_name}
                            </p>
                            <div className="flex items-center justify-between pt-3">
                                <div className="text-sm rounded-lg border border-black-3 px-2 py-1 font-semibold">
                                    {project.tags
                                        .slice(0, 2)
                                        .map((tag, index) => (
                                            <span key={tag.id}>
                                                {tag.name}
                                                {index !== 1 && ' · '}
                                            </span>
                                        ))}
                                </div>
                                <a
                                    href={project.project_url}
                                    type="button"
                                    className="h-8 rounded-lg border border-black-3"
                                >
                                    <img
                                        src={ArrowRightProjects}
                                        alt="right arrow button"
                                        className="h-full"
                                    />
                                </a>
                            </div>
                        </div>
                    ))}
                </div>
            )}
        </div>
    )
}

export default ProjectsCard
