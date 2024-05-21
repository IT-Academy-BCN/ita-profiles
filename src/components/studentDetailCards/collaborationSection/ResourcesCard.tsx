import folder from '../../../assets/img/folder.png'

const ResourcesCard: React.FC = () => (
  <div className="flex w-2/3 md:w-1/2 items-start justify-between rounded-md bg-ita-wiki p-3 pl-7 pt-3">
    <div className="flex flex-col">
      <p className="text-2xl text-white">0</p>
      <p className="text-md text-white">Recursos subidos</p>
      <p className="mt-2 text-sm font-light text-white">ita-wiki</p>
    </div>
    <div className="w-9 -mt-1">
      <img src={folder} alt="folder" className="h-full" />
    </div>
  </div>
)

export default ResourcesCard
