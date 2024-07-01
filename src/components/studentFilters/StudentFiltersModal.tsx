import StudentFiltersContent from './StudentFiltersContent'

interface TStudentsFiltersModal {
  handleOpenModal: () => void
}

const StudentsFiltersModal: React.FC<TStudentsFiltersModal> = ({
  handleOpenModal,
}) => (
  <dialog id="filtersModal" className="modal modal-open modal-bottom flex">
    <div className="modal-box bg-white shadow-sm w-auto flex-1 flex flex-col gap-4 mx-4 p-8 pt-12 pb-5">
      <StudentFiltersContent />
      <div className="modal-action">
        <form method="dialog" className="flex w-full justify-center ">
          {/* if there is a button in form, it will close the modal */}
          <button
            type="button"
            className="border-gray-400 hover:bg-gray-100 w-full rounded-lg border px-4 py-1 font-semibold"
            onClick={handleOpenModal}
          >
            Cerrar
          </button>
        </form>
      </div>
    </div>
  </dialog>
)

export default StudentsFiltersModal
