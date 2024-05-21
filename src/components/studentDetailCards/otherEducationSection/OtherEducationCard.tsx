const OtherEducationCard: React.FC = () => {
  const education = [
    {
      id: 0,
      title: 'FP aplicaciones móviles',
      site: 'Instituto Lope de Vega',
      years: ['2019', '2020'],
      hours: '450',
    },
    {
      id: 1,
      title: 'Desarrollo backend con Java',
      site: 'Udemy',
      years: ['2018'],
      hours: '80',
    },
  ]

  return (
    <div data-testid="OtherEducationCard">
      <h3 className="text-lg font-bold text-black-3">Otra formación</h3>
      <div className="flex flex-col pt-3">
        {education.map((item, index) => (
          <div key={item.id} className="flex flex-col ">
            <h4 className=" font-bold">{item.title}</h4>
            <div className="flex flex-col ">
              <p className="text-sm font-semibold text-black-2">{item.site}</p>
              <p className="text-sm font-semibold text-black-2">
                {item.years.join(' - ')} · {item.hours} horas
              </p>
              {index !== education.length - 1 && (
                <span className="h-px w-full bg-gray-4-base md:bg-gray-5-background my-3" />
              )}
            </div>
          </div>
        ))}
      </div>
    </div>
  )
}

export default OtherEducationCard
