function Select({id, name, className, options, onChange}){
    return(
        <select name={name} id={id} className={className} onChange={onChange}>
            {options.map((option, k) => {
                return <option value={option} key={k}>{option}</option>
            })}
        </select>
    );
}

export default Select;