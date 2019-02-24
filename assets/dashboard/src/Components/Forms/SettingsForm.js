import React from 'react'
import UploadFile from "./UploadFile";

class SettingsForm extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            isChecked: false,
            name: '',
            id: ''
        }
    }

    handleCheck = (e) => {

        let isChecked = e.target.checked;
        this.setState({isChecked: isChecked});
        this.props.handleUpdate(this.state.id, isChecked);
    };

    componentDidMount() {
        let {setting} = this.props;

        console.log(setting);
        this.setState({
            isChecked: setting.value, name: setting.name, id: setting.id
        });
    }



    render() {

        return (
          <div>
              <form>
                  <label>{this.state.name}</label>
                  <input type='checkbox' defaultChecked={this.state.isChecked} onChange={this.handleCheck}/>
              </form>
          </div>
        )
    }
}

export default SettingsForm