function Submit({className, type, name, onClick}){
    return (
        <input type="submit" className={className} value={name} onClick={onClick} />
    );
}

export default Submit;