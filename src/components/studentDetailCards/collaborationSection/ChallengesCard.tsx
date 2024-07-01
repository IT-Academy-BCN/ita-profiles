import target from '../../../assets/img/target.png'

const ChallengesCard = () => (
  <div className="flex w-2/3 md:w-1/2 items-start justify-between rounded-md bg-ita-challenges p-3 pl-7 pt-3">
    <div className="flex flex-col ">
      <p className="text-2xl text-white">0</p>
      <p className="text-md text-white">Retos completados</p>
      <p className="mt-2 text-sm font-light text-white">ita-challenges</p>
    </div>
    <div className="w-10 -mt-2">
      <img src={target} alt="folder" className="w-full" />
    </div>
  </div>
)

export default ChallengesCard
