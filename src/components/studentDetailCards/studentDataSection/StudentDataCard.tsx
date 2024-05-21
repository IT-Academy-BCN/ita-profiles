import { useState } from 'react'
import { Github, Linkedin } from '../../../assets/svg'
import { Stud1 as ProfilePicture } from '../../../assets/img'

const StudentDataCard: React.FC = () => {
  const [showFullDescription, setShowFullDescription] = useState(false)

  const toggleDescription = () => {
    setShowFullDescription(!showFullDescription)
  }

  const studentData = [
    {
      id: 1,
      profileDetail: {
        fullname: 'Marta Oliveras',
        subtitle: 'Full-stack developer PHP',
        socialMedia: {
          linkedin: {
            url: 'LinkedIn',
          },
          github: {
            url: 'Github',
          },
        },
        about: {
          description:
            'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Impedit, voluptatum iste. Commodi, libero adipisci. Dignissimos consequuntur ab excepturi incidunt ducimus!',
        },
        tags: [
          'PHP',
          'Laravel',
          'SQL',
          'MongoDB',
          'Javascript',
          'React',
          'Redux',
          'Github',
          'CI/CD',
          'TDD',
        ],
      },
    },
  ]

  return (
    <div data-testid="StudentDataCard">
      {studentData.map((student) => (
        <div key={student.id} className="flex flex-col gap-4">
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
                    {student.profileDetail.fullname}
                  </h2>
                  <p className="text-gray-2">
                    {student.profileDetail.subtitle}
                  </p>
                </div>
                <div className="flex gap-4">
                  <div className="flex gap-1">
                    <img src={Github} alt="github icon" />
                    {student.profileDetail.socialMedia.github.url}
                  </div>
                  <div className="flex gap-1">
                    <img src={Linkedin} alt="linkedin icon" />
                    {student.profileDetail.socialMedia.linkedin.url}
                  </div>
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
                    ? student.profileDetail.about.description
                    : `${student.profileDetail.about.description
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
              {student.profileDetail.tags.map((tag) => (
                <li
                  key={tag}
                  className="rounded-md bg-gray-5-background px-2 py-1 text-sm"
                >
                  {tag}
                </li>
              ))}
            </ul>
          </div>
        </div>
      ))}
    </div>
  )
}

export default StudentDataCard
