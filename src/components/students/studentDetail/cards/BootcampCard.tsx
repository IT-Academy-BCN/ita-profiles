import React from 'react'
import medal from '../../../../assets/img/medal-dynamic-color.png'
import { useAppSelector } from '../../../../hooks/ReduxHooks'
import LoadingSpiner from '../../../atoms/LoadingSpiner'

const BootcampCard: React.FC = () => {
    const { studentBootcamps } = useAppSelector((state) => state.ShowStudentReducer)
    const { bootcampData, isErrorBootcamp, isLoadingBootcamp } = studentBootcamps

    return (
        <div className="flex flex-col gap-4" data-testid="BootcampCard">
            <h3 className="text-lg font-bold">Datos del bootcamp</h3>
            {isLoadingBootcamp && <LoadingSpiner />}
            {isErrorBootcamp && (
                <LoadingSpiner
                    textContent="Upss!!"
                    type="loading-bars"
                    textColor="red"
                />
            )}
            {!isLoadingBootcamp &&
                (bootcampData.length === 0 ? (
                    <div className="flex flex-col gap-1 rounded-md bg-gray-5-background p-5 shadow-[0_4px_0_0_rgba(0,0,0,0.25)]">
                        <p className="text- font-medium text-black-3">
                            - Bootcamp no terminado -
                        </p>
                    </div>
                ) : (
                    bootcampData.map((bootcamp) => (
                        <div className="flex flex-col gap-1 rounded-md bg-gray-5-background p-5 shadow-[0_4px_0_0_rgba(0,0,0,0.25)]">
                            <div
                                className="flex items-center"
                                key={bootcamp.bootcamp_id}
                            >
                                <img
                                    src={medal}
                                    alt="Medal"
                                    className="w-16 pe-1"
                                />
                                <div className="flex flex-col gap-1">
                                    <p className="text-base font-semibold leading-tight text-black-3">
                                        {bootcamp.name}
                                    </p>
                                    <p className="text-sm font-medium text-black-2">
                                        Finalizado: {bootcamp.bootcamp_end_date}
                                    </p>
                                </div>
                            </div>
                        </div>
                    ))
                ))}
        </div>
    )
}
export default BootcampCard
