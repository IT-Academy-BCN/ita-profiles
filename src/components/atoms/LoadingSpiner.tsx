const LoadingSpiner: React.FC<{
    textContent?: string,
    type?: string,
    textColor?: string,
    spinerColor?: string
}> = ({ textContent = 'Loading', type = "loading-spinner", textColor = "currentColor", spinerColor = "#C20087" }) => (
    <small className='text-md flex items-center gap-4'>
        <i style={{ color: `${textColor}` }}>{textContent}</i> <span className={`loading ${type} text-[${spinerColor}]`} />
    </small>
)

export default LoadingSpiner
