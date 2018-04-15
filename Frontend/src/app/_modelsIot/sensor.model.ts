export enum SensorTipology {
    luminosità = 'luminosità',
    pioggia = 'pioggia',
    pressione = 'pressione',
    inquinamento = 'inquinamento',
    temperatura = 'temperatura',
    umidità = 'umidità',
    vento = 'vento',
}

export class SensorModel {

    id: number;
    typology: SensorTipology;
    brand: string;

} 

export class SensorAddModel {

    Tipo:string;
    Marca: string;
    Stato: number;
    ImpiantoId: number;

} 