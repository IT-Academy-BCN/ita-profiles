import medal from '../../../assets/img/medal-dynamic-color.png'

const BootcampCard: React.FC = () => (
  <div className="flex flex-col gap-4" data-testid="BootcampCard">
    <h3 className="text-lg font-bold">Datos del bootcamp</h3>
    <div className="flex items-center gap-1 rounded-md bg-gray-5-background p-5 shadow-[0_4px_0_0_rgba(0,0,0,0.25)]">
      <img src={medal} alt="Medal" className="w-16" />
      <div className="flex flex-col">
        <p className="text-xl font-semibold leading-tight text-black-3">
          Full-stack PHP
        </p>
        <p className="text-base font-semibold text-black-2">
          Finalizado el 12 de noviembre de 2023
        </p>
      </div>
    </div>
  </div>
)

export default BootcampCard
