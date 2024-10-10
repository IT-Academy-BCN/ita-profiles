import { useState } from 'react'
import StudentsList from './StudentsList'
import StudentsFiltersModal from './studentDetail/filters/StudentFiltersModal'

const StudentsLayout: React.FC = () => {
    const [openModal, setOpenModal] = useState(false)
    const handleOpenModal = () => {
        setOpenModal(!openModal)
    }
    return (
        <div className="flex flex-col w-full gap-20">
            <div className="flex justify-between">
                <h3 className="pl-5 text-2xl font-bold text-black-3">
                    Alumn@s
                </h3>
                {/* Filter button only seen in small screens */}
                <button
                    type="button"
                    className="border-gray-400 hover:bg-gray-100 rounded-lg border px-4 py-1 font-semibold md:hidden"
                    onClick={handleOpenModal}
                >
                    Filtrar
                </button>
            </div>
            <StudentsList />
            {openModal && (
                <StudentsFiltersModal handleOpenModal={handleOpenModal} />
            )}
        </div>
    )
}
export default StudentsLayout
