import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, FormArray, FormControl, Validators } from '@angular/forms';
import { Router, ActivatedRoute, NavigationEnd } from '@angular/router';

import { SharedDataService, UserService } from '../_services';
import { DetectionModel, ThirdActorModel, ThirdActorPostModel } from '../_modelsIot';

@Component({
  selector: 'app-stats',
  templateUrl: './stats.component.html',
  styleUrls: ['./stats.component.css']
})
export class StatsComponent implements OnInit {

  max: number = 0;
  detections: DetectionModel;
  plants: any;
  arrayChartLabels: number[] = [];
  lineChartData: any[] = [];

  thirdActorForm: FormGroup;
  success: number = 0;

  constructor(
    private router: Router,
    private fb: FormBuilder,
    private shared: SharedDataService,
    private userService: UserService) { }

  ngOnInit() {

    this.plants = this.shared.plants;
    this.detections = this.shared.detections;

    this.thirdActorForm = this.fb.group({
      'Username': ['', Validators.compose([Validators.required, Validators.pattern("^[a-z0-9!#$%&'*+\/=?^_`{|}~.-]+@[a-z0-9]([a-z0-9-]*[a-z0-9])?(\.[a-z0-9]([a-z0-9-]*[a-z0-9])?)*$")])],
      'Password': ['', Validators.compose([Validators.required, Validators.minLength(8)])],
      'Plants': this.fb.array([])
    })

    this.load()

    this.max = Math.max(
      this.shared.arrayTemp.length,
      this.shared.arrayUmid.length,
      this.shared.arrayPrec.length,
      this.shared.arrayPres.length,
      this.shared.arrayVent.length,
      this.shared.arrayInqu.length)

    for (let i = 0; i < this.max; i++) {
      this.arrayChartLabels[i] = ++i;
    }

  }

  //Componente Grafico
  public lineChartLabels: Array<any> = this.arrayChartLabels;
  public lineChartOptions: any = {
    responsive: true
  };
  public lineChartLegend: boolean = true;
  public lineChartType: string = 'line';

  // events
  public chartClicked(e: any): void {
    console.log(e);
  }

  public chartHovered(e: any): void {
    console.log(e);
  }

  public load(): void {
    let _lineChartData: Array<any> = new Array(this.lineChartData.length);
    _lineChartData = [
      { data: this.shared.arrayTemp, label: 'Temperatura' },
      { data: this.shared.arrayUmid, label: 'Umidità' },
      { data: this.shared.arrayPrec, label: 'Precipitazioni' },
      { data: this.shared.arrayPres, label: 'Pressione' },
      { data: this.shared.arrayVent, label: 'Vento' },
      { data: this.shared.arrayInqu, label: 'Inquinamento' },
    ]
    this.lineChartData = _lineChartData;
  }

  //Componente Tabella
  settings = {
    columns: {
      Data: {
        title: 'Data',
        editable: false,
      },
      Ora: {
        title: 'Ora',
        editable: false,
      },
      Id: {
        title: 'ID del sensore',
        editable: false,
      },
      Marca: {
        title: 'Marca del sensore',
        editable: false,
      },
      Tipo: {
        title: 'Tipologia',
        editable: false,
      },
      Valore: {
        title: 'Misurazione',
        editable: false,
      },
      Errore: {
        title: 'Errore',
        editable: false,
      }
    },
    actions: false
  };

  data = this.shared.detections;

  public insertThirdActor(model: ThirdActorModel, isValid: boolean) {

    let obj: ThirdActorPostModel;
    obj = new ThirdActorPostModel();

    let z: number = 0;
    let plantsId: number[] = [];

    for (let i = 0; i < model.Plants.length; i++) {
      for (let j = 0; j < this.shared.plants.length; j++ ) {
        if (model.Plants[i] == this.shared.plants[j].Nome) {

          plantsId[z] = +this.shared.plants[j].Id;
          z++;
        
        }
      }
    }

    obj.Username = model.Username;
    obj.Password = model.Password;
    obj.ClienteId = this.shared.clienteId.ClienteId;
    obj.Impianti = plantsId;

    this.userService.postThirdActor(obj).subscribe(
      data => {
        if (data.Value == true) {
          this.success = 1;
        }

        if (data.Value == false) {
          this.success = 2;
        }
      })
  }

  onChange(plantNome: string, isChecked: boolean) {

    const plantsFormArray = <FormArray>this.thirdActorForm.controls.Plants;

    if (isChecked) {
      plantsFormArray.push(new FormControl(plantNome));
    } else {
      let index = plantsFormArray.controls.findIndex(x => x.value == plantNome)
      plantsFormArray.removeAt(index);
    }
  }



}
