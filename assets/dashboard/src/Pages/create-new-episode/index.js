import React from 'react'
import CreateEpisodeForm from '../../Components/Forms/CreateEpisodeForm'
import {bindActionCreators} from "redux";
import {fetchDetails, updateDetails, uploadImage} from "../../modules/podcast";
import {connect} from "react-redux";
import {fetchEpisodes, updateEpisode, uploadAudio, saveNew} from "../../modules/episode";

class CreateNewEpisode extends React.Component {

    handleSave = (title, description, audio, image) => {
        this.props.saveNew(title, description, audio, image);
    };

    render() {

        let {isNewEpisodeSaving} = this.props;

        return (
            <section>
                <CreateEpisodeForm
                    isNewEpisodeSaving={isNewEpisodeSaving}
                    handleSave={this.handleSave}
                />
            </section>
        )
    }
}

const mapStateToProps = ({ episode }) => ({
    episodes: episode.episodes,
    isAudioUploading: episode.isAudioUploading,
    isImageUploading: episode.isImageUploading,
    isNewEpisodeSaving: episode.isNewEpisodeSaving,
});

const mapDispatchToProps = dispatch =>
    bindActionCreators(
        {
            saveNew,
        },
        dispatch
    );

export default connect(
    mapStateToProps,
    mapDispatchToProps
)(CreateNewEpisode)