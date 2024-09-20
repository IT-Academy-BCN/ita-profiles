import { useState } from 'react'
import { Github, Linkedin } from '../../../assets/svg'
import { Stud1 as ProfilePicture } from '../../../assets/img'
import { ITag } from '../../../interfaces/interfaces'
import { useAppSelector } from '../../../hooks/ReduxHooks'
import LoadingSpiner from '../../atoms/LoadingSpiner'

const StudentDataCard: React.FC = () => {
  const [showFullDescription, setShowFullDescription] = useState(false)

  const toggleDescription = () => {
    setShowFullDescription(!showFullDescription)
  }

  const { studenDetails } = useAppSelector(state => state.ShowStudenReducer)
  const { aboutData, isErrorAboutData, isLoadindAboutData } = studenDetails

  return (
    <div data-testid="StudentDataCard">
      {isLoadindAboutData && <LoadingSpiner />}
      {isErrorAboutData && <LoadingSpiner textContent='Upss!!' type="loading-bars" textColor="red" />}
      {!isLoadindAboutData && <div key={aboutData.id} className="flex flex-col gap-4">
        <div className="flex gap-3">
          <img
            src={ProfilePicture}
            alt="Profile"
            className="h-20 w-20 flex-none rounded-lg"
          />
          <div className="flex">
            <div className="flex flex-col gap-2">
              <div className="flex flex-col">
                <h2 className="text-xl font-bold">
                  {aboutData.fullname}
                </h2>
                <p className="text-gray-2">
                  {aboutData.subtitle}
                </p>
              </div>
              <div className="flex gap-4">
                <a href={aboutData.social_media.github.url} className="flex gap-1">
                  <img src={Github} alt="github icon" />
                  Github
                </a>
                <a href={aboutData.social_media.linkedin.url} className="flex gap-1">
                  <img src={Linkedin} alt="linkedin icon" />
                  LinkedIn
                </a>
              </div>
            </div>
          </div>
        </div>
        <div className="flex flex-col gap-6">
          <div className="flex flex-col gap-2">
            <h3 className="text-lg font-bold">About</h3>
            <div>
              <p className="text-sm">
                {showFullDescription
                  ? aboutData.about
                  : `${aboutData.about
                    .split(' ')
                    .slice(0, 15)
                    .join(' ')}...`}
                {!showFullDescription && (
                  <button
                    type="button"
                    onClick={toggleDescription}
                    className="text-sm text-gray-3"
                  >
                    ver más
                  </button>
                )}
              </p>
              {showFullDescription && (
                <p className="text-sm">
                  <button
                    type="button"
                    onClick={toggleDescription}
                    className="text-sm text-gray-3"
                  >
                    ver menos
                  </button>
                </p>
              )}
            </div>
          </div>
          <ul className="flex flex-wrap gap-2">
            {aboutData.tags.map((tag: ITag) => (
              <li
                key={tag.id}
                className="rounded-md bg-gray-5-background px-2 py-1 text-sm"
              >
                {tag.name}
              </li>
            ))}
          </ul>
        </div>
      </div>}
    </div>
  )
}

export default StudentDataCard
