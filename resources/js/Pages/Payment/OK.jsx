export default function Payment(){
    return (
        <div>
            <div className="flex items-center justify-center h-screen">
                <div className="w-full max-w-sm border border-gray-300 rounded-lg">
                    <div className="bg-blue-300 p-2 text-center font-semibold">
                        Success!
                    </div>
                    <div className="grid grid-cols-1 gap-4 p-2">
                        Pagamento andato a buon fine.<br/>
                        L'ordine vi verà consegnato a breve
                    </div>                    
                </div>
            </div>
        </div>
    )
}
