import { Button } from '../../../atoms/Button'
import StudentFiltersContent from './StudentFiltersContent'

interface TStudentsFiltersModal {
  handleOpenModal: () => void
}

const StudentsFiltersModal: React.FC<TStudentsFiltersModal> = ({
  handleOpenModal,
}) => (
  <dialog id="filtersModal" className="modal modal-open modal-bottom flex">
    <div className="modal-box bg-white w-auto flex-1 flex flex-col gap-4 mx-4 p-8 pt-12 pb-5">
      <StudentFiltersContent />
      <div className="modal-action">
        <form method="dialog" className="flex w-full justify-center ">
          <Button
            defaultButton={false}
            className="rounded-lg px-6 py-3 font-semibold hover:bg-gray-100"
            onClick={handleOpenModal}
          >
            Cerrar
          </Button>
        </form>
      </div>
    </div>
  </dialog>
)

export default StudentsFiltersModal
