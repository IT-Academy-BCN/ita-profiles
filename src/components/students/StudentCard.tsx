import { useAppDispatch } from '../../hooks/ReduxHooks'
import { openUserPanel } from '../../store/slices/user/details'
import { TStudentList } from '../../../types'
import { useStudentIdContext } from '../../context/StudentIdContext'

const StudentCard: React.FC<TStudentList> = ({
    fullname,
    photo,
    subtitle,
    tags,
    id,
}) => {
    const dispatch = useAppDispatch()
    const { setStudentUUID } = useStudentIdContext()

    const handleUserDetailToggler = () => {
        dispatch(openUserPanel())
    }
    const handleStudentSelect = () => {
        setStudentUUID(id)
    }
    return (
        // eslint-disable-next-line jsx-a11y/no-static-element-interactions
        <div
            className="max-w-md flex cursor-pointer flex-col gap-3 rounded-2xl px-6 py-4 hover:bg-gray-4-base"
            onClick={() => {
                handleUserDetailToggler()
                handleStudentSelect()
            }}
            onKeyDown={(e) => {
                if (e.key === 'Enter') {
                    handleUserDetailToggler()
                    handleStudentSelect()
                }
            }}
        >
            <div className="flex gap-5">
                <div className="flex-none">
                    <img
                        src={photo}
                        alt={`Foto de ${fullname}`}
                        className="w-20 rounded-xl"
                    />
                </div>
                <div className="flex flex-col gap-2 pt-2">
                    <div className="text-xl font-bold leading-5 text-black-3">
                        {fullname}
                    </div>
                    <div className="leading-5 text-gray-3">{subtitle}</div>
                </div>
            </div>

            <div className="flex flex-wrap gap-1">
                {tags?.map((tag) => (
                    <span
                        key={tag.id}
                        className="rounded-md bg-gray-3 bg-opacity-30 px-2 py-1 text-xs text-black-2"
                    >
                        {tag.name}
                    </span>
                ))}
            </div>
        </div>
    )
}

export default StudentCard
